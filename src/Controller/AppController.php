<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 */
class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authorization.Authorization');
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Flash');
        // $this->loadComponent('FormProtection');
    }

    // IMPORTANT: add : void and EventInterface import
    public function beforeFilter(EventInterface|\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);

        // Use the modern method name for Cake 5.x Authentication
        $this->Authentication->addUnauthenticatedActions(['login', 'register', 'display', 'index']);
    }
}

