<?php
declare(strict_types=1);

namespace App\Controller;

class OrdersController extends AppController
{
    /**
     * Checkout page
     * - Reads cart from session
     * - Calculates totals
     * - Handles order creation on POST
     */
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
            $order = $this->Orders->patchEntity($order, $this->request->getData());

            // Attach calculated values
            $identity        = $this->Authentication->getIdentity();
            $order->user_id  = $identity ? $identity->getIdentifier() : null;
            $order->subtotal = $subtotal;
            $order->shipping = $shipping;
            $order->discount = $discount;
            $order->total    = $total;

            // Set status depending on payment method
            if ($order->payment_method === 'cod') {
                $order->status = 'pending (Pay on Delivery)'; // Special label for COD
            } else {
                $order->status = 'pending'; // Default for other payment methods
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




