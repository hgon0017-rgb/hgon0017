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

        // TODO: 实际查询订单数据
        $orders = [
            ['id' => 101, 'date' => '2025-09-01', 'status' => 'Shipped'],
            ['id' => 102, 'date' => '2025-09-05', 'status' => 'Processing'],
        ];
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
                unset($data['password']); // 留空则不改密码
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

        // TODO: 实际应从 DB 查用户的列表
        $lists = [
            ['id'=>1, 'name'=>'Office Supplies'],
            ['id'=>2, 'name'=>'Electronics'],
        ];
        $this->set(compact('lists'));
    }
}
