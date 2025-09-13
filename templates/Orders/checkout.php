<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 * @var array<array{id:int,name:string,image:string,price:float,qty:int,image?:string}> $cartItems
 * @var float $subtotal
 * @var float $shipping
 * @var float $discount
 * @var float $total
 */
?>
<style>
    body {
        background: #f9fafb;
        font-family: Arial, sans-serif;
    }

    .checkout-container {
        max-width: 1200px;
        margin: 30px auto;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .card h3 {
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: 700;
        color: #111827;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #4f46e5;
        outline: none;
    }

    .checkout-btn {
        width: 100%;
        background: #4f46e5;
        color: #fff;
        border: none;
        padding: 14px;
        font-size: 16px;
        border-radius: 10px;
        cursor: pointer;
        transition: .2s;
    }

    .checkout-btn:hover {
        filter: brightness(1.1);
    }

    .order-summary .line {
        display: flex;
        justify-content: space-between;
        margin: 8px 0;
    }

    .order-summary .total {
        font-size: 18px;
        font-weight: 700;
    }

    .payment-methods label {
        display: block;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .payment-extra {
        margin-top: 15px;
        display: none;
    }

    .product-row {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 10px;
    }

    .product-row img {
        width: 60px;
        height: 60px;
        border: 1px solid #ddd;
        border-radius: 8px;
        object-fit: contain;
        margin-right: 12px;
    }

    .product-info {
        flex-grow: 1;
    }

    .product-info div {
        font-size: 14px;
    }

    .product-subtotal {
        font-weight: 600;
    }

    .card-icons {
        margin-top: 5px;
    }
    .card-icons img {
        height: 25px;
        margin-right: 10px;
    }
</style>

<div class="checkout-container">
    <!-- Left: Checkout Form -->
    <div>
        <?= $this->Form->create($order) ?>

        <!-- Personal Information -->
        <div class="card">
            <h3>Personal Information</h3>
            <?= $this->Form->control('name', [
                'label' => false,
                'placeholder' => 'Full Name',
                'class' => 'form-control',
                'required' => true
            ]) ?>
            <?= $this->Form->control('email', [
                'label' => false,
                'placeholder' => 'Email',
                'class' => 'form-control',
                'required' => true
            ]) ?>
            <?= $this->Form->control('phone', [
                'label' => false,
                'placeholder' => 'Phone Number',
                'class' => 'form-control',
                'required' => true
            ]) ?>
        </div>

        <!-- Shipping Address -->
        <div class="card">
            <h3>Shipping Address</h3>
            <?= $this->Form->control('address', [
                'label' => false,
                'placeholder' => 'Street Address',
                'class' => 'form-control',
                'required' => true
            ]) ?>
            <?= $this->Form->control('city', [
                'label' => false,
                'placeholder' => 'City',
                'class' => 'form-control',
                'required' => true
            ]) ?>
            <?= $this->Form->control('postal_code', [
                'label' => false,
                'placeholder' => 'Postal Code',
                'class' => 'form-control',
                'required' => true
            ]) ?>
        </div>

        <!-- Payment Methods -->
        <div class="card payment-methods">
            <h3>Payment Methods</h3>
            <?= $this->Form->radio('payment_method', [
                ['value' => 'bank_transfer', 'text' => 'Direct Debit (BSB & Account)'],
                ['value' => 'credit_card', 'text' => 'Credit / Debit Card']
            ], ['hiddenField' => false]) ?>

            <!-- Bank Transfer fields -->
            <div class="payment-extra" id="bank-fields">
                <?= $this->Form->control('account_name', [
                    'label' => false,
                    'placeholder' => 'Account Holder Name',
                    'class' => 'form-control',
                    'title' => 'fill in your bank account name',
                    'required' => true
                ]) ?>
                <?= $this->Form->control('account_number', [
                    'label' => false,
                    'placeholder' => 'Account Number',
                    'class' => 'form-control',
                    'pattern' => '^[0-9]{8,12}$',
                    'title' => 'Account Number must be 8–12 digits',
                    'required' => true
                ]) ?>
                <?= $this->Form->control('bsb', [
                    'label' => false,
                    'placeholder' => 'BSB (6 digits)',
                    'class' => 'form-control',
                    'pattern' => '^[0-9]{6}$',
                    'title' => 'BSB must be exactly 6 digits',
                    'required' => true
                ]) ?>
            </div>

            <!-- Credit Card fields -->
            <div class="payment-extra" id="credit-fields">
                <div class="card-icons">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="MasterCard">
                </div>
                <?= $this->Form->control('cardholder_name', [
                    'label' => false,
                    'placeholder' => 'Cardholder Name',
                    'class' => 'form-control'
                ]) ?>
                <?= $this->Form->control('card_number', [
                    'label' => false,
                    'placeholder' => 'Card Number',
                    'class' => 'form-control',
                    'pattern' => '^[0-9]{13,19}$',
                    'title' => 'Please enter a valid card number (13-19 digits)'
                ]) ?>
                <?= $this->Form->control('exp_date', [
                    'label' => false,
                    'placeholder' => 'MM/YY',
                    'class' => 'form-control',
                    'pattern' => '^(0[1-9]|1[0-2])\/[0-9]{2}$',
                    'title' => 'Enter expiration as MM/YY'
                ]) ?>
                <?= $this->Form->control('cvc', [
                    'label' => false,
                    'placeholder' => 'CVC',
                    'class' => 'form-control',
                    'pattern' => '^[0-9]{3,4}$',
                    'title' => 'CVC must be 3 or 4 digits'
                ]) ?>
            </div>
        </div>
    </div>

    <!-- Right: Order Summary -->
    <div>
        <div class="card order-summary">
            <h3>Order Summary</h3>

            <!-- Product list -->
            <?php foreach ($cartItems as $it): ?>
                <div class="product-row">
                    <?= $this->Html->image(h($it['image']), [
                        'alt' => $it['name'],
                        'style' => 'width:60px;height:60px;object-fit:contain;border:1px solid #ddd;border-radius:8px;margin-right:12px;'
                    ]) ?>
                    <div class="product-info">
                        <div style="font-weight:600"><?= h($it['name']) ?></div>
                        <div style="color:#6b7280;font-size:13px">
                            Qty: <?= (int)$it['qty'] ?> × A$<?= number_format($it['price'],2) ?>
                        </div>
                    </div>
                    <div class="product-subtotal">
                        A$<?= number_format($it['price'] * $it['qty'], 2) ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Totals -->
            <div class="line"><span>Subtotal</span><span>A$<?= number_format($subtotal,2) ?></span></div>
            <div class="line"><span>Shipping</span><span>A$<?= number_format($shipping,2) ?></span></div>
            <div class="line"><span>Discount</span><span>A$<?= number_format($discount,2) ?></span></div>
            <div class="line total"><span>Total</span><span>A$<?= number_format($total,2) ?></span></div>

            <br>
            <?= $this->Form->button(__('Checkout'), ['class' => 'checkout-btn']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!-- JS: toggle payment fields -->
<script>
    document.addEventListener("DOMContentLoaded", function(){
        const radios = document.querySelectorAll("input[name='payment_method']");
        const creditFields = document.getElementById("credit-fields");
        const bankFields = document.getElementById("bank-fields");

        function toggleFields() {
            const selected = document.querySelector("input[name='payment_method']:checked");
            if (!selected) return;

            if (selected.value === "credit_card") {
                creditFields.style.display = "block";
                bankFields.style.display = "none";
                // disable bank fields
                bankFields.querySelectorAll("input").forEach(i => i.disabled = true);
                creditFields.querySelectorAll("input").forEach(i => i.disabled = false);
            } else if (selected.value === "bank_transfer") {
                bankFields.style.display = "block";
                creditFields.style.display = "none";
                // disable card fields
                creditFields.querySelectorAll("input").forEach(i => i.disabled = true);
                bankFields.querySelectorAll("input").forEach(i => i.disabled = false);
            } else {
                creditFields.style.display = "none";
                bankFields.style.display = "none";
            }
        }

        radios.forEach(r => r.addEventListener("change", toggleFields));
        toggleFields();
    });

</script>








