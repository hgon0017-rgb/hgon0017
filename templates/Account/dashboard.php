<?php
/**
 * Account dashboard (dynamic)
 *
 * @var \App\View\AppView $this
 */
$this->assign('title', 'My Account');

// ====== Links (adjust if your routes differ) ======
$orderHistoryUrl = $this->Url->build(['controller' => 'Account', 'action' => 'orders']);
$editDetailsUrl  = $this->Url->build(['controller' => 'Account', 'action' => 'details']);
$trackOrderUrl   = $this->Url->build(['controller' => 'Account', 'action' => 'track_order']);
$myListsUrl      = $this->Url->build(['controller' => 'Account', 'action' => 'lists']);

// ====== Dynamic data ======
// Read cart items directly from the session
$session = $this->request->getSession();
$cart    = (array)$session->read('Cart.items') ?: [];   // Expected: [product_id => ['name','price','qty']]
$cartCount = 0;
$cartSubtotal = 0.0;
foreach ($cart as $row) {
    $qty   = (int)($row['qty'] ?? 0);
    $price = (float)($row['price'] ?? 0);
    $cartCount    += $qty;
    $cartSubtotal += $qty * $price;
}

// Read other stats from logged-in identity (these may come from your DB)
$lifetimeSpend    = (float)($this->Identity?->get('lifetime_spend') ?? 0);
$favoriteProducts = (int)($this->Identity?->get('favorites_count') ?? 0);
$accountBalance   = (float)($this->Identity?->get('balance') ?? 0);

// Spending target and coupon (replace with DB/config if needed)
$target      = 100.0;
$couponValue = 10.0;

// Calculate progress = lifetime + current cart subtotal
$spent   = max(0.0, $lifetimeSpend + $cartSubtotal);
$percent = (int)min(100, $target > 0 ? round(($spent / $target) * 100) : 0);
$left    = max(0.0, $target - $spent);
?>

<section class="account-dashboard">

    <style>
        /* Layout and style definitions */
        .account-dashboard { max-width: 1280px; margin: 0 auto; padding: 32px 16px; }
        .account-dashboard h2 { font-size: 2.25rem; margin: 0 0 8px; }
        .account-dashboard .muted { color: #6b7280; }
        .account-dashboard .divider { margin: 14px 0 18px; border: 0; border-top: 1px solid rgba(0,0,0,.06); }

        .account-dashboard .main-grid { display: grid; grid-template-columns: 1fr; gap: 24px; }
        @media (min-width: 1100px) { .account-dashboard .main-grid { grid-template-columns: 1.15fr 1fr; } }

        .account-dashboard .tiles { display: grid; grid-template-columns: 1fr; gap: 18px; }
        .account-dashboard .tile-link {
            text-decoration: none; color: inherit; display: block; border-radius: 18px;
            background: #fff; box-shadow: 0 8px 22px rgba(0,0,0,.06); border: 1px solid rgba(0,0,0,.06);
            transition: transform .12s ease, box-shadow .12s ease;
        }
        .account-dashboard .tile-link:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(0,0,0,.10); }
        .account-dashboard .tile { display: grid; grid-template-columns: auto 1fr auto; align-items: center; gap: 18px; padding: 20px 22px; }
        .account-dashboard .tile .icon { width: 48px; height: 48px; border-radius: 12px; background: #f3f4f6; display:flex; align-items:center; justify-content:center; font-size: 22px; }
        .account-dashboard .tile h3 { margin: 0; font-size: 1.75rem; font-weight: 800; letter-spacing: .2px; }
        .account-dashboard .tile p { margin: 6px 0 0; color:#6b7280; font-size: 1.02rem; }
        .account-dashboard .tile .open-btn { margin-left: 10px; background: #f3f4f6; border: 1px solid rgba(0,0,0,.08); padding: 10px 14px; border-radius: 12px; font-weight: 600; color:#111827; }

        .account-dashboard .stats-grid { display: grid; grid-template-columns: 1fr; gap: 16px; margin-top: 8px; }
        @media (min-width: 520px) { .account-dashboard .stats-grid { grid-template-columns: 1fr 1fr; } }
        .account-dashboard .stat-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); padding: 18px 20px; display: flex; align-items: center; gap: 14px; }
        .account-dashboard .stat-card .icon { width: 48px; height: 48px; border-radius: 12px; display:flex; align-items:center; justify-content:center; font-size: 22px; font-weight: 700; }
        .account-dashboard .icon.green  { background:#e8f7ef; color:#2f9e44; }
        .account-dashboard .icon.purple { background:#f3e8ff; color:#9333ea; }
        .account-dashboard .stat-title { margin:0; font-weight:700; font-size:1.1rem; color:#111827; }
        .account-dashboard .stat-value { margin:4px 0 0; font-weight:800; font-size:1.5rem; color:#111827; white-space:nowrap; }

        .account-dashboard .cards-grid { display:grid; gap:16px; margin-top:22px; grid-template-columns: 1fr; }
        .account-dashboard .card { background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.06); border:1px solid rgba(0,0,0,.06); }
        .account-dashboard .card-header { padding:12px 16px; border-bottom:1px solid rgba(0,0,0,.08); font-weight:700; background:#f9fafb; }
        .account-dashboard .card-body { padding:16px; color:#374151; line-height:1.6; }

        .account-dashboard .progress-wrap { margin-top: 8px; }
        .account-dashboard .progress-bar { width: 100%; height: 24px; background: #eef2ff; border-radius: 12px; overflow: hidden; position: relative; box-shadow: inset 0 0 0 1px rgba(0,0,0,.05); }
        .account-dashboard .progress-bar > .fill { height: 100%; background: linear-gradient(90deg, #22c55e, #16a34a); width: 0%; transition: width .3s ease; color:#fff; font-weight:700; display:flex; align-items:center; justify-content:center; }
        .account-dashboard .progress-info { margin-top: 8px; font-size: .95rem; color:#6b7280; }
        .account-dashboard .badge { display:inline-block; padding: 4px 8px; border-radius: 999px; background:#ecfeff; color:#0891b2; font-weight:700; font-size:.9rem; border: 1px solid rgba(8,145,178,.25); }

        .account-dashboard .hello { margin-bottom: 10px; }
        .account-dashboard .hello h1 { margin:0 0 4px; font-size: 2rem; font-weight: 800; }
    </style>

    <!-- Greeting -->
    <div class="hello">
        <h1>Hi <?= h($this->Identity?->get('email') ?? 'User'); ?></h1>
        <div class="muted">Welcome back — manage your account and orders below.</div>
    </div>

    <hr class="divider" />

    <div class="main-grid">
        <!-- Left column with quick links -->
        <div class="tiles">
<!--            <a class="tile-link" href="--><?php //= $orderHistoryUrl ?><!--"><div class="tile"><div class="icon">📦</div><div><h3>Order history →</h3><p>View your order history and track orders</p></div><div class="open-btn">Open ›</div></div></a>-->
            <a class="tile-link" href="<?= $editDetailsUrl ?>"><div class="tile"><div class="icon">👤</div><div><h3>Edit details →</h3><p>Manage account details</p></div><div class="open-btn">Open ›</div></div></a>
            <a class="tile-link" href="<?= $trackOrderUrl ?>"><div class="tile"><div class="icon">🚚</div><div><h3>Track order →</h3><p>Check delivery status</p></div><div class="open-btn">Open ›</div></div></a>
            <a class="tile-link" href="<?= $myListsUrl ?>"><div class="tile"><div class="icon">📋</div><div><h3>My lists →</h3><p>Create and save product lists</p></div><div class="open-btn">Open ›</div></div></a>
        </div>

        <!-- Right column with dynamic stats -->
        <div>
            <div class="muted" style="margin-bottom:8px;">Live stats</div>

            <div class="stats-grid">
                <div class="stat-card"><div class="icon green">💼</div><div><p class="stat-title">Account balance</p><p class="stat-value">$<?= number_format($accountBalance, 2) ?></p></div></div>
<!--                <div class="stat-card"><div class="icon purple">❤️</div><div><p class="stat-title">Favorite products</p><p class="stat-value">--><?php //= number_format($favoriteProducts) ?><!--</p></div></div>-->
                <div class="stat-card"><div class="icon">🛒</div><div><p class="stat-title">Cart</p><p class="stat-value"><span id="cart-count"><?= (int)$cartCount ?></span> items · $<span id="cart-subtotal"><?= number_format($cartSubtotal, 2) ?></span></p></div></div>
            </div>

            <div class="muted" style="margin-top:22px; margin-bottom:8px;">Purchase progress</div>

            <div class="cards-grid">
                <div class="card">
                    <div class="card-header">Purchase progress</div>
                    <div class="card-body">
                        <p>Spend <strong>$<?= number_format($target, 0) ?></strong> to receive a <span class="badge">$<?= number_format($couponValue, 0) ?> coupon</span>.</p>
                        <div class="progress-wrap">
                            <div class="progress-bar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= $percent ?>">
                                <div id="progress-fill" class="fill" style="width: <?= $percent ?>%;"><span id="progress-text"><?= $percent ?>%</span></div>
                            </div>
                        </div>
                        <p id="progress-info" class="progress-info"<?= $left <= 0 ? ' style="color:#16a34a;"' : '' ?>>
                            <?php if ($left > 0): ?>
                                You’ve spent <strong>$<span id="spent"><?= number_format($spent, 2) ?></span></strong>.
                                                                                                                      Only <strong>$<span id="left"><?= number_format($left, 2) ?></span></strong> left to unlock your coupon.
                            <?php else: ?>
                                🎉 Great! You’ve unlocked the coupon. Check your coupons page to use it.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Optional auto-refresh if /cart/summary.json exists -->
<script>
    (function() {
        const url = <?= json_encode($this->Url->build(["controller"=>"Cart","action"=>"summary","_ext"=>"json"])) ?>;
        async function tick() {
            try {
                const res = await fetch(url, {headers: {"X-Requested-With":"XMLHttpRequest"}});
                if (!res.ok) return;
                const data = await res.json(); // {count, subtotal}

                // Update cart values
                document.getElementById('cart-count').textContent = Number(data.count || 0);
                document.getElementById('cart-subtotal').textContent = Number(data.subtotal || 0).toFixed(2);

                // Recalculate progress
                const lifetimeSpent = <?= json_encode($lifetimeSpend) ?>;
                const target = <?= json_encode($target) ?>;
                const currentSpent = Math.max(0, lifetimeSpent + Number(data.subtotal || 0));
                const left = Math.max(0, target - currentSpent);
                const pct = Math.min(100, target > 0 ? Math.round((currentSpent / target) * 100) : 0);

                document.getElementById('spent').textContent = currentSpent.toFixed(2);
                document.getElementById('left').textContent = left.toFixed(2);
                document.getElementById('progress-fill').style.width = pct + '%';
                document.getElementById('progress-text').textContent = pct + '%';

                const info = document.getElementById('progress-info');
                if (left <= 0) {
                    info.style.color = '#16a34a';
                    info.innerHTML = '🎉 Great! You’ve unlocked the coupon. Check your coupons page to use it.';
                }
            } catch(_) {}
        }
        setInterval(tick, 8000); // poll every 8s
    })();
</script>
