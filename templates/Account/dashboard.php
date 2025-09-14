<?php
/**
 * Account dashboard (responsive for desktop + iPhone)
 *
 * @var \App\View\AppView $this
 */
$this->assign('title', 'My Account');

/* ---------- Links ---------- */
$orderHistoryUrl = $this->Url->build(['controller' => 'Account', 'action' => 'orders']);
$editDetailsUrl  = $this->Url->build(['controller' => 'Account', 'action' => 'details']);
$trackOrderUrl   = $this->Url->build(['controller' => 'Account', 'action' => 'track_order']);
$myListsUrl      = $this->Url->build(['controller' => 'Account', 'action' => 'lists']);

/* ---------- Dynamic data ---------- */
$session = $this->request->getSession();
$cart    = (array)$session->read('Cart.items') ?: []; // Expected format: [product_id => ['name','price','qty']]

$cartCount    = 0;
$cartSubtotal = 0.0;
foreach ($cart as $row) {
    $qty   = (int)($row['qty'] ?? 0);
    $price = (float)($row['price'] ?? 0);
    $cartCount    += $qty;
    $cartSubtotal += $qty * $price;
}

/* Lifetime spend (fallback to 0 if not available) */
$lifetimeSpend = (float)($this->Identity?->get('lifetime_spend') ?? 0);

/* Coupon unlock target and coupon value */
$target      = 100.0;
$couponValue = 10.0;

/* Calculate progress = lifetime spend + current cart subtotal */
$spent   = max(0.0, $lifetimeSpend + $cartSubtotal);
$percent = (int)min(100, $target > 0 ? round(($spent / $target) * 100) : 0);
$left    = max(0.0, $target - $spent);

function h_($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
?>

<section class="account-dashboard">
    <style>
        :root {
            --bg: #f6f7fb;
            --card: #ffffff;
            --muted:#6b7280;
            --ink:#111827;
            --ink-2:#374151;
            --line: rgba(0,0,0,.06);
            --line-2: rgba(0,0,0,.08);
            --brand:#3b82f6;
            --surface:#f9fafb;
            --radius-lg: 18px;
            --radius-md: 14px;
            --shadow: 0 8px 22px rgba(0,0,0,.06);
            --shadow-lg: 0 12px 30px rgba(0,0,0,.10);
        }

        .account-dashboard {
            max-width: 1280px;
            margin: 0 auto;
            padding: 24px 14px;
            color: var(--ink);
        }

        /* Greeting */
        .hello h1 {
            margin: 0 0 6px;
            font-size: clamp(20px, 4.5vw, 28px);
            font-weight: 800;
            letter-spacing: .2px;
        }
        .hello .muted { color: var(--muted); }

        /* Divider */
        .divider { border: 0; border-top:1px solid var(--line); margin: 14px 0 18px; }

        /* Main grid: single column on mobile, two columns on desktop */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        @media (min-width: 1100px) {
            .main-grid { grid-template-columns: 1.15fr 1fr; }
        }

        /* Tiles for quick links */
        .tiles {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }
        .tile-link {
            text-decoration: none; color: inherit; display:block;
            background: var(--card);
            border:1px solid var(--line);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            transition: transform .12s ease, box-shadow .12s ease;
        }
        .tile-link:active { transform: scale(.99); }
        .tile-link:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }

        .tile {
            display:grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 14px;
            padding: 16px 16px;
        }
        @media (min-width: 420px) {
            .tile { padding: 18px 20px; gap: 18px; }
        }
        .tile .icon {
            width:44px;height:44px;border-radius:12px;background:#f3f4f6;
            display:flex;align-items:center;justify-content:center;font-size:20px;
        }
        .tile h3 {
            margin: 0;
            font-size: clamp(18px, 4vw, 22px);
            font-weight: 800;
        }
        .tile p { margin: 6px 0 0; color: var(--muted); font-size: 0.98rem; }
        .open-btn {
            background:#f3f4f6;border:1px solid var(--line-2);
            padding: 9px 12px;border-radius: 12px; font-weight: 600; color: var(--ink);
        }

        /* Stats (only Cart kept, Balance and Favorites removed) */
        .stats {
            display:grid; gap: 12px; grid-template-columns: 1fr;
            margin-top: 6px;
        }
        @media (min-width: 520px) { .stats { grid-template-columns: 1fr 1fr; } }
        .stat {
            background: var(--card);
            border-radius: 16px;
            border:1px solid var(--line);
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            padding: 14px 16px;
            display:flex;align-items:center;gap:12px;
        }
        .stat .icon {
            width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;
            font-size: 20px;font-weight:700;background:#eef2ff;color:#4338ca;
        }
        .stat-title { margin:0; font-weight:700; font-size:1.05rem; color:var(--ink); }
        .stat-value { margin:4px 0 0; font-weight:800; font-size:1.35rem; color:var(--ink); white-space:nowrap; }

        /* Cards (purchase progress) */
        .cards-grid { display:grid; gap:14px; margin-top:18px; grid-template-columns: 1fr; }
        .card {
            background:var(--card);
            border-radius:16px; border:1px solid var(--line);
            box-shadow:0 2px 12px rgba(0,0,0,.06); overflow:hidden;
        }
        .card-header { padding:12px 16px; border-bottom:1px solid var(--line-2); font-weight:700; background:var(--surface); }
        .card-body { padding:16px; color:var(--ink-2); line-height:1.6; font-size: 15px; }

        /* Progress bar */
        .progress-wrap { margin-top: 8px; }
        .progress-bar {
            width:100%; height:22px; background:#eef2ff; border-radius:12px; overflow:hidden;
            box-shadow: inset 0 0 0 1px var(--line);
        }
        .progress-bar .fill {
            height:100%; background:linear-gradient(90deg,#22c55e,#16a34a);
            width:0%; transition: width .3s ease;
            color:#fff; font-weight:700; display:flex; align-items:center; justify-content:center;
            font-size: 13px;
        }
        .progress-info { margin-top: 8px; font-size:.95rem; color:var(--muted); }
        .badge {
            display:inline-block; padding: 4px 8px; border-radius: 999px;
            background:#ecfeff; color:#0891b2; font-weight:700; font-size:.9rem; border:1px solid rgba(8,145,178,.25);
        }

        /* Small screen optimization (iPhone) */
        @media (max-width: 390px) {
            .tile .icon { width:40px;height:40px; }
            .open-btn { padding:8px 10px; border-radius:10px; }
            .stat .icon { width:40px;height:40px; }
            .stat-value { font-size: 1.2rem; }
            .card-body { padding:14px; }
        }
    </style>

    <!-- Greeting -->
    <div class="hello">
        <h1>Hi <?= h_($this->Identity?->get('email') ?? 'User'); ?></h1>
        <div class="muted">Welcome back — manage your account and orders below.</div>
    </div>

    <hr class="divider"/>

    <div class="main-grid">
        <!-- Left column: quick links -->
        <div class="tiles">
            <a class="tile-link" href="<?= $orderHistoryUrl ?>">
                <div class="tile">
                    <div class="icon">📦</div>
                    <div>
                        <h3>Order history →</h3>
                        <p>View your order history and track orders</p>
                    </div>
                    <div class="open-btn">Open ›</div>
                </div>
            </a>

            <a class="tile-link" href="<?= $editDetailsUrl ?>">
                <div class="tile">
                    <div class="icon">👤</div>
                    <div>
                        <h3>Edit details →</h3>
                        <p>Manage account details</p>
                    </div>
                    <div class="open-btn">Open ›</div>
                </div>
            </a>

            <a class="tile-link" href="<?= $trackOrderUrl ?>">
                <div class="tile">
                    <div class="icon">🚚</div>
                    <div>
                        <h3>Track order →</h3>
                        <p>Check delivery status</p>
                    </div>
                    <div class="open-btn">Open ›</div>
                </div>
            </a>

            <a class="tile-link" href="<?= $myListsUrl ?>">
                <div class="tile">
                    <div class="icon">📋</div>
                    <div>
                        <h3>My lists →</h3>
                        <p>Create and save product lists</p>
                    </div>
                    <div class="open-btn">Open ›</div>
                </div>
            </a>
        </div>

        <!-- Right column: only Cart stats + progress -->
        <div>
            <div class="muted" style="margin-bottom:8px;">Live stats</div>

            <div class="stats">
                <div class="stat">
                    <div class="icon">🛒</div>
                    <div>
                        <p class="stat-title">Cart</p>
                        <p class="stat-value">
                            <span id="cart-count"><?= (int)$cartCount ?></span> items · $
                            <span id="cart-subtotal"><?= number_format($cartSubtotal, 2) ?></span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="cards-grid">
                <div class="card">
                    <div class="card-header">Purchase progress</div>
                    <div class="card-body">
                        <p>
                            Spend <strong>$<?= number_format($target, 0) ?></strong> to receive a
                            <span class="badge">$<?= number_format($couponValue, 0) ?> coupon</span>.
                        </p>

                        <div class="progress-wrap">
                            <div class="progress-bar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= $percent ?>">
                                <div id="progress-fill" class="fill" style="width: <?= $percent ?>%;">
                                    <span id="progress-text"><?= $percent ?>%</span>
                                </div>
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

<!-- Optional auto-refresh for cart and progress (requires /Cart/summary.json API) -->
<script>
    (function () {
        const url = <?= json_encode($this->Url->build(["controller"=>"Cart","action"=>"summary","_ext"=>"json"])) ?>;

        async function tick() {
            try {
                const res = await fetch(url, { headers: { "X-Requested-With":"XMLHttpRequest" } });
                if (!res.ok) return;
                const data = await res.json(); // {count, subtotal}

                const count = Number(data.count || 0);
                const subtotal = Number(data.subtotal || 0);

                // Update cart stats
                const c = document.getElementById('cart-count');
                const s = document.getElementById('cart-subtotal');
                if (c) c.textContent = count;
                if (s) s.textContent = subtotal.toFixed(2);

                // Recalculate progress
                const lifetimeSpent = <?= json_encode($lifetimeSpend) ?>;
                const target = <?= json_encode($target) ?>;

                const currentSpent = Math.max(0, lifetimeSpent + subtotal);
                const left = Math.max(0, target - currentSpent);
                const pct = Math.min(100, target > 0 ? Math.round((currentSpent / target) * 100) : 0);

                const spentEl = document.getElementById('spent');
                const leftEl = document.getElementById('left');
                const fill = document.getElementById('progress-fill');
                const txt = document.getElementById('progress-text');
                const info = document.getElementById('progress-info');

                if (spentEl) spentEl.textContent = currentSpent.toFixed(2);
                if (leftEl) leftEl.textContent = left.toFixed(2);
                if (fill) fill.style.width = pct + '%';
                if (txt) txt.textContent = pct + '%';

                if (info && left <= 0) {
                    info.style.color = '#16a34a';
                    info.innerHTML = '🎉 Great! You’ve unlocked the coupon. Check your coupons page to use it.';
                }
            } catch (_) {}
        }

        // Auto-refresh every 8s (safe for iPhone and desktop)
        setInterval(tick, 8000);
    })();
</script>
