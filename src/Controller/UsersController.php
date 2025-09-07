<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * beforeFilter
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        //AuthorizationRequiredException
        $this->Authorization->skipAuthorization();

        // if user is custumer intercept and jump
        $identity = $this->request->getAttribute('identity');
        if ($identity && $identity->get('role') === 'customer') {
            $adminActions = ['index', 'view', 'add', 'edit', 'delete'];
            $action = $this->request->getParam('action');
            if (in_array($action, $adminActions, true)) {
                return $this->redirect(['controller' => 'Account', 'action' => 'dashboard']);
            }
        }
    }

    /**
     * Index method
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $this->paginate = [
            'order' => [
                'Users.created'  => 'desc',
                'Users.modified' => 'desc',
            ],
        ];

        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    /**
     * View method
     */
    public function view(?string $id = null)
    {
        $this->Authorization->skipAuthorization();

        $user = $this->Users->get($id, contain: []);
        $this->set(compact('user'));
    }

    /**
     * Add method
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            // 白名单 role
            $allowedRoles = ['customer', 'admin'];
            if (!in_array($user->role ?? 'customer', $allowedRoles, true)) {
                $user->role = 'customer';
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $this->set(compact('user'));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $this->Authorization->skipAuthorization();

        try {
            $user = $this->Users->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('User not found or already deleted.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $allowedRoles = ['customer', 'admin'];
            if (!in_array($user->role ?? 'customer', $allowedRoles, true)) {
                $user->role = 'customer';
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $this->set(compact('user'));
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['post', 'delete']);

        try {
            $user = $this->Users->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->warning(__('User not found (maybe already removed).'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Login method
     */
    public function login()
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $identity = $this->Authentication->getIdentity();
            $role = $identity?->get('role');

            if ($role === 'admin') {
                return $this->redirect(['controller' => 'Users', 'action' => 'index']);
            }
            return $this->redirect(['controller' => 'Account', 'action' => 'dashboard']);
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid email or password'));
        }
    }

    /**
     * Logout method
     */
    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['get', 'post']);

        $this->Authentication->logout();
        return $this->redirect(['action' => 'login']);
    }
}
