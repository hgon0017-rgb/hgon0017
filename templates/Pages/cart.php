<?php
/**
 * templates/Pages/cart.php
 * Pretty cart page with modern UI.
 */

$this->assign('title', 'Shopping Cart');

/* ---- Demo data (replace with session/db in real app) ---- */
$cartItems = [
    ['id'=>1,'name'=>'Custom Flag','image'=>'flags-custom.jpg','price'=>29.99,'qty'=>2],
    ['id'=>2,'name'=>'Corporate Banner','image'=>'printing-banner-3.jpg','price'=>35.00,'qty'=>1],
];

/* ---- Calc ---- */
$subtotal = 0;
foreach ($cartItems as $i) { $subtotal += $i['price'] * $i['qty']; }
$shipping = $subtotal > 60 ? 0 : 7.90;
$discount = 0.00;
$total    = max(0, $subtotal - $discount + $shipping);
?>

<style>
    /* -------- Layout -------- */
    .cart-wrap{max-width:1200px;margin:20px auto;padding:0 16px;}
    .cart-grid{display:grid;grid-template-columns:1fr 320px;gap:20px;}
    @media (max-width: 980px){ .cart-grid{grid-template-columns:1fr;} }

    /* -------- Head -------- */
    .cart-head{
        background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:16px 18px;margin-bottom:14px;
        display:flex;align-items:center;gap:10px;
    }
    .cart-head h2{margin:0;font-size:22px;}
    .cart-head .emoji{font-size:22px}

    /* -------- Card -------- */
    .card{
        background:#fff;border:1px solid #e5e7eb;border-radius:14px;
    }
    .card-body{padding:14px;}
    .card-title{font-weight:700;margin:0 0 8px 0}

    /* -------- Table (desktop) -------- */
    .cart-table{width:100%;border-collapse:collapse;font-size:14px;}
    .cart-table th,.cart-table td{border-bottom:1px solid #f0f2f5;padding:14px;}
    .cart-table th{background:#fafbfc;text-align:left;color:#374151}
    .cart-row:last-child td{border-bottom:none}

    /* product cell */
    .prod{
        display:flex;align-items:center;gap:14px;min-width:220px;
    }
    .thumb{
        width:70px;height:70px;border:1px solid #ececec;border-radius:10px;overflow:hidden;background:#f8f9fb;
        display:flex;align-items:center;justify-content:center;
    }
    .thumb img{width:100%;height:100%;object-fit:contain}

    /* qty stepper */
    .qty{
        display:inline-flex;align-items:center;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;
    }
    .qty input{
        width:48px;height:36px;border:none;text-align:center;font-size:14px;outline:none;background:#fff;
    }
    .qty button{
        width:36px;height:36px;border:none;background:#f3f4f6;cursor:pointer;font-weight:700;
    }
    .qty button:hover{background:#e5e7eb}

    /* price cells */
    .price{font-weight:600;color:#111827}
    .muted{color:#6b7280}

    /* actions */
    .btn{display:inline-block;padding:8px 14px;border-radius:10px;font-size:14px;text-decoration:none;cursor:pointer;transition:.18s all}
    .btn-dark{background:#111827;color:#fff}
    .btn-dark:hover{filter:brightness(1.05);transform:translateY(-1px)}
    .btn-ghost{background:#f3f4f6;color:#111827}
    .btn-ghost:hover{background:#e5e7eb}
    .btn-danger{background:#c81e1e;color:#fff}
    .btn-danger:hover{filter:brightness(1.05)}

    /* -------- Summary card -------- */
    .summary .line{display:flex;justify-content:space-between;align-items:center;margin:10px 0}
    .summary .line strong{font-size:16px}
    .summary .total{font-size:20px;font-weight:800}
    .hr{height:1px;background:#eef0f3;margin:12px 0}
    .badge-free{background:#10b981;color:#fff;border-radius:999px;padding:2px 10px;font-size:12px}
    .checkout{width:100%;text-align:center;padding:12px 16px;border-radius:12px;background:#4f46e5;color:#fff;text-decoration:none;display:inline-block}
    .checkout:hover{filter:brightness(1.05);transform:translateY(-1px)}

    /* -------- Empty state -------- */
    .empty{
        background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:28px;text-align:center
    }
    .empty h3{margin:0 0 6px 0}
    .empty p{color:#6b7280;margin:0 0 14px 0}

    /* -------- Mobile rows -------- */
    @media (max-width:720px){
        .cart-table th:nth-child(3), .cart-table td:nth-child(3), /* image */
        .cart-table th:nth-child(5), .cart-table td:nth-child(5)  /* subtotal */
        {display:none}
    }
</style>

<div class="cart-wrap">
    <div class="cart-head">
        <span class="emoji">🛒</span>
        <h2>Your Shopping Cart</h2>
    </div>

    <?php if (!$cartItems): ?>
        <div class="empty">
            <h3>Your cart is empty</h3>
            <p>Browse our products and add items to your cart to get started.</p>
            <?= $this->Html->link('Explore Products →', ['controller'=>'Products','action'=>'index'], ['class'=>'btn btn-dark']) ?>
        </div>
    <?php else: ?>

        <div class="cart-grid">
            <!-- Left: items -->
            <div class="card">
                <div class="card-body">
                    <table class="cart-table">
                        <thead>
                        <tr>
                            <th style="width:42%">Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($cartItems as $it): ?>
                            <tr class="cart-row">
                                <td>
                                    <div class="prod">
                                        <div class="thumb">
                                            <?= $this->Html->image('img/' . h($it['image']), ['alt'=>$it['name']]) ?>
                                        </div>
                                        <div>
                                            <div style="font-weight:600"><?= h($it['name']) ?></div>
                                            <div class="muted">SKU #<?= (1000 + $it['id']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="thumb" style="width:60px;height:60px">
                                        <?= $this->Html->image('img/' . h($it['image']), ['alt'=>$it['name']]) ?>
                                    </div>
                                </td>
                                <td class="price">A$<?= number_format($it['price'],2) ?></td>
                                <td>
                                    <div class="qty">
                                        <button type="button" aria-label="Decrease">−</button>
                                        <input type="text" value="<?= (int)$it['qty'] ?>" readonly>
                                        <button type="button" aria-label="Increase">＋</button>
                                    </div>
                                </td>
                                <td class="price">A$<?= number_format($it['price'] * $it['qty'],2) ?></td>
                                <td>
                                    <?= $this->Html->link('Remove', '#', ['class'=>'btn btn-danger']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:10px">
                        <?= $this->Html->link('← Continue Shopping', ['controller'=>'Products','action'=>'index'], ['class'=>'btn btn-ghost']) ?>
                        <?= $this->Html->link('Update Cart', '#', ['class'=>'btn btn-dark']) ?>
                    </div>
                </div>
            </div>

            <!-- Right: summary -->
            <div class="card summary">
                <div class="card-body">
                    <div class="card-title">Order Summary</div>
                    <div class="line"><span>Subtotal</span><span class="price">A$<?= number_format($subtotal,2) ?></span></div>
                    <div class="line">
          <span>Shipping
            <?= $shipping == 0 ? '<span class="badge-free" style="margin-left:6px">FREE</span>' : '' ?>
          </span>
                        <span class="price">A$<?= number_format($shipping,2) ?></span>
                    </div>
                    <div class="line"><span>Discount</span><span class="price">− A$<?= number_format($discount,2) ?></span></div>
                    <div class="hr"></div>
                    <div class="line"><strong>Total</strong><span class="total">A$<?= number_format($total,2) ?></span></div>

                    <div style="margin-top:14px">
                        <?= $this->Html->link('Checkout →', ['controller'=>'Orders','action'=>'checkout'], ['class'=>'checkout']) ?>
                    </div>

                    <div style="margin-top:12px;font-size:12px;color:#6b7280">
                        Spend <strong>A$<?= number_format(max(0, 60-$subtotal),2) ?></strong> more for free shipping.
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>
