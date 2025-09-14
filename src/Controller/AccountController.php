<?php
declare(strict_types=1);

namespace App\Controller;

class AccountController extends AppController
{
    public function dashboard()
    {
        $this->Authorization->skipAuthorization();
        $user = $this->request->getAttribute('identity');
        $this->set(compact('user'));
    }

    public function orders()
    {
        $this->Authorization->skipAuthorization();

        // Empty order list
        $orders = [];

        $this->set(compact('orders'));
    }

    public function details()
    {
        $this->Authorization->skipAuthorization();

        $usersTable = $this->fetchTable('Users');
        $current = $usersTable->get(
            (int)$this->request->getAttribute('identity')->get('id')
        );

        if ($this->request->is(['post','patch','put'])) {
            $data = $this->request->getData();
            if (isset($data['password']) && $data['password'] === '') {
                unset($data['password']); //if it is blank, the password will not be changed
            }
            $user = $usersTable->patchEntity($current, $data);
            if ($usersTable->save($user)) {
                $this->Flash->success('Profile updated.');
                return $this->redirect(['action'=>'dashboard']);
            }
            $this->Flash->error('Could not update profile.');
        }

        $this->set('user', $current);
    }

    public function trackOrder()
    {
        $this->Authorization->skipAuthorization();
        $order = null;

        if ($this->request->is('post')) {
            $no = trim((string)$this->request->getData('order_no'));
            if ($no === '101') {
                $order = ['id'=>101,'status'=>'Shipped','date'=>'2025-09-01'];
            } elseif ($no === '102') {
                $order = ['id'=>102,'status'=>'Processing','date'=>'2025-09-05'];
            }
        }

        $this->set(compact('order'));
    }

    public function lists()
    {
        $this->Authorization->skipAuthorization();
        $user = $this->request->getAttribute('identity');

        if ($this->request->is('post')) {
            $name = trim((string)$this->request->getData('name'));
            if ($name !== '') {
                $this->Flash->success("List '{$name}' created. (fake data)");
                return $this->redirect(['action'=>'lists']);
            }
        }

        // TODO: Find the user list from DB
        $lists = [
            ['id'=>1, 'name'=>'Office Supplies'],
            ['id'=>2, 'name'=>'Electronics'],
        ];
        $this->set(compact('lists'));
    }
}
