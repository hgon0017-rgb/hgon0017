<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc.
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\AbstractIdentifier;
use Authentication\Middleware\AuthenticationMiddleware;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Policy\OrmResolver;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;

class Application extends BaseApplication implements AuthenticationServiceProviderInterface, \Authorization\AuthorizationServiceProviderInterface
{
    /**
     * @return void
     */
    public function bootstrap(): void
    {
        parent::bootstrap();

        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }

        $this->addPlugin('Authentication');
        $this->addPlugin('Authorization');
    }

    /**
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue
     * @return \Cake\Http\MiddlewareQueue
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // Catch exceptions and render error pages
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))

            // Serve plugin/theme assets
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // Routing
            ->add(new RoutingMiddleware($this))

            // Parse JSON/form bodies into $request->getData()
            ->add(new BodyParserMiddleware())

            // Authentication must run before Authorization
            ->add(new AuthenticationMiddleware($this))

            // Authorization (policies)
            ->add(new AuthorizationMiddleware($this))

            // CSRF protection
            ->add(new CsrfProtectionMiddleware(['httponly' => true]));

        return $middlewareQueue;
    }

    /**
     * @param ServerRequestInterface $request
     * @return AuthenticationServiceInterface
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $authenticationService = new AuthenticationService([
            'unauthenticatedRedirect' => Router::url([
                'controller' => 'Auth',
                'action' => 'login',
                'plugin' => null,
                'prefix' => null,
            ]),
            'queryParam' => 'redirect',
        ]);

        $authentication_fields = [
            AbstractIdentifier::CREDENTIAL_USERNAME => 'email',
            AbstractIdentifier::CREDENTIAL_PASSWORD => 'password',
        ];

        $passwordIdentifier = [
            'Authentication.Password' => [
                'fields' => $authentication_fields,
            ],
        ];

        // Load the authenticators, you want session first
        $authenticationService->loadAuthenticator('Authentication.Session', [
            'identifier' => $passwordIdentifier,
        ]);

        // Configure form data check to pick email and password
        $authenticationService->loadAuthenticator('Authentication.Form', [
            'identifier' => $passwordIdentifier,
            'fields' => $authentication_fields,
            'loginUrl' => Router::url([
                'controller' => 'Auth',
                'action' => 'login',
                'plugin' => null,
                'prefix' => null,
            ]),
        ]);

        return $authenticationService;
    }


    /**
     * Get the authorization for the application
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Authorization\AuthorizationServiceInterface
     */
    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        $resolver = new OrmResolver();

        return new AuthorizationService($resolver);
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     */
    public function services(ContainerInterface $container): void
    {
    }
}
