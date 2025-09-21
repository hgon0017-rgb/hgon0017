<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class OrdersController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authorization.Authorization');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('admin');
        $query = $this->Orders->find()
            ->contain(['Users']);
        $query = $this->Authorization->applyScope($query);
        $orders = $this->paginate($query);

        $this->set(compact('orders'));
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $order = $this->Orders->get($id, contain: ['Users']);
        $this->Authorization->authorize($order);
        $this->set(compact('order'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('admin');
        $order = $this->Orders->newEmptyEntity();
        $this->Authorization->authorize($order);
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $users = $this->Orders->Users->find('list', limit: 200)->all();
        $this->set(compact('order', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $order = $this->Orders->get($id, contain: []);
        $this->Authorization->authorize($order);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $users = $this->Orders->Users->find('list', limit: 200)->all();
        $this->set(compact('order', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        $this->Authorization->authorize($order);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function checkout()
    {
        // Skip CakePHP Authorization (we manage access manually)
        $this->Authorization->skipAuthorization();

        $session   = $this->request->getSession();
        $cartItems = (array)$session->read('Cart.items'); // Read cart items from session

        // Redirect if cart is empty
        if (empty($cartItems)) {
            $this->Flash->error(__('Your cart is empty.'));
            return $this->redirect(['controller' => 'Products', 'action' => 'index']);
        }

        // Calculate order amounts
        $subtotal = 0.0;
        foreach ($cartItems as $i) {
            $subtotal += (float)$i['price'] * (int)$i['qty'];
        }
        $shipping = $subtotal > 60 ? 0.00 : 7.90; // Free shipping if subtotal > 60
        $discount = 0.00; // Default no discount
        $total    = max(0, $subtotal - $discount + $shipping);

        // Create a new empty Order entity
        $order = $this->Orders->newEmptyEntity();

        if ($this->request->is('post')) {
            // Patch submitted form data into the entity
            $order = $this->Orders->patchEntity($order, $this->request->getData(), [
                'fields' => [
                    'name', 'email', 'phone', 'address', 'city', 'postal_code',
                    'payment_method',
                    'cardholder_name', 'card_number', 'exp_date', 'cvc',
                    'account_name', 'account_number', 'bsb'
                ]
            ]);

            // Attach calculated values
            $identity        = $this->Authentication->getIdentity();
            $order->user_id  = $identity ? $identity->getIdentifier() : null;
            $order->subtotal = $subtotal;
            $order->shipping = $shipping;
            $order->discount = $discount;
            $order->total    = $total;

            // Set status depending on payment method
            if ($order->payment_method === 'bank_transfer') {
                // Validate required bank transfer fields
                if (empty($order->account_name) || empty($order->account_number) || empty($order->bsb)) {
                    $this->Flash->error(__('Please fill in all bank transfer details.'));
                } else {
                    $order->status = 'pending (Bank Transfer)';
                }
            } elseif ($order->payment_method === 'credit_card') {
                $order->status = 'paid (Card Payment)';
            } else {
                $order->status = 'pending';
            }

            // Save order into database
            if ($this->Orders->save($order)) {
                // Clear cart after successful save
                $session->delete('Cart.items');

                // Redirect to success page
                return $this->redirect(['action' => 'success', $order->id]);
            }

            // If saving failed, show error
            $this->Flash->error(__('Could not place order. Please try again.'));
        }

        // Pass variables to the checkout template
        $this->set(compact('order', 'cartItems', 'subtotal', 'shipping', 'discount', 'total'));
    }


    /**
     * Success page
     * - Shows order confirmation and purchased items
     */
    public function success($orderId = null)
    {
        $this->Authorization->skipAuthorization();

        $order = $this->Orders->get($orderId);

        // Get cart items (saved before clearing session, or reload via DB if you persist items separately)
        $session = $this->request->getSession();
        $cartItems = (array)$session->read('Cart.last_order_items');

        $this->set(compact('order', 'cartItems'));
    }
}
