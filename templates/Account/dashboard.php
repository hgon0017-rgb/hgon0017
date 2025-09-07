<?php
/**
 * Account dashboard view
 *
 * @var \App\View\AppView $this
 */

// ====== Routes (adjust to match your project routes) ======
$orderHistoryUrl = $this->Url->build(['controller' => 'Account', 'action' => 'orders']);
$editDetailsUrl  = $this->Url->build(['controller' => 'Account', 'action' => 'details']);
$trackOrderUrl   = $this->Url->build(['controller' => 'Account', 'action' => 'track_order']);
$myListsUrl      = $this->Url->build(['controller' => 'Account', 'action' => 'lists']);

// ====== Stats & Progress Data (replace with dynamic values) ======
$accountBalance   = 46760.89;                            // Example: account balance
$favoriteProducts = (int)($this->Identity?->get('favorites_count') ?? 8); // Example: favorite products count
$target           = 100.0;                               // Spending target
$couponValue      = 10.0;                                // Coupon value
$spent            = (float)($this->Identity?->get('lifetime_spend') ?? 60.0); // Example: already spent
$spent            = max(0, $spent);
$percent          = (int)min(100, round(($target > 0 ? ($spent / $target) * 100 : 0)));
$leftAmount       = max(0.0, $target - $spent);
?>
<section class="account-dashboard">

    <style>
        .account-dashboard { max-width: 1280px; margin: 0 auto; padding: 32px 16px; }
        .account-dashboard h2 { font-size: 2.25rem; margin: 0 0 8px; }
        .account-dashboard .muted { color: #6b7280; }
        .account-dashboard .divider { margin: 14px 0 18px; border: 0; border-top: 1px solid rgba(0,0,0,.06); }

        /* Main two-column grid layout */
        .account-dashboard .main-grid { display: grid; grid-template-columns: 1fr; gap: 24px; }
        @media (min-width: 1100px) { .account-dashboard .main-grid { grid-template-columns: 1.15fr 1fr; } }

        /* Left column: account tiles */
        .account-dashboard .tiles { display: grid; grid-template-columns: 1fr; gap: 18px; }
        .account-dashboard .tile-link {
            text-decoration: none; color: inherit; display: block; border-radius: 18px;
            background: #fff; box-shadow: 0 8px 22px rgba(0,0,0,.06); border: 1px solid rgba(0,0,0,.06);
            transition: transform .12s ease, box-shadow .12s ease;
        }
        .account-dashboard .tile-link:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(0,0,0,.10); }
        .account-dashboard .tile {
            display: grid; grid-template-columns: auto 1fr auto; align-items: center;
            gap: 18px; padding: 20px 22px;
        }
        .account-dashboard .tile .icon {
            width: 48px; height: 48px; border-radius: 12px; background: #f3f4f6;
            display:flex; align-items:center; justify-content:center; font-size: 22px;
        }
        .account-dashboard .tile h3 { margin: 0; font-size: 1.75rem; font-weight: 800; letter-spacing: .2px; }
        .account-dashboard .tile p { margin: 6px 0 0; color:#6b7280; font-size: 1.02rem; }
        .account-dashboard .tile .open-btn {
            margin-left: 10px; background: #f3f4f6; border: 1px solid rgba(0,0,0,.08);
            padding: 10px 14px; border-radius: 12px; font-weight: 600; color:#111827;
        }

        /* Right column: statistic cards */
        .account-dashboard .stats-grid { display: grid; grid-template-columns: 1fr; gap: 16px; margin-top: 8px; }
        @media (min-width: 520px) { .account-dashboard .stats-grid { grid-template-columns: 1fr 1fr; } }
        .account-dashboard .stat-card {
            background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 18px 20px; display: flex; align-items: center; gap: 14px;
        }
        .account-dashboard .stat-card .icon {
            width: 48px; height: 48px; border-radius: 12px; display:flex; align-items:center; justify-content:center;
            font-size: 22px; font-weight: 700;
        }
        .account-dashboard .icon.green  { background:#e8f7ef; color:#2f9e44; }
        .account-dashboard .icon.purple { background:#f3e8ff; color:#9333ea; } /* Favorite products color */
        .account-dashboard .stat-title { margin:0; font-weight:700; font-size:1.1rem; color:#111827; }
        .account-dashboard .stat-value { margin:4px 0 0; font-weight:800; font-size:1.5rem; color:#111827; white-space:nowrap; }

        /* Bottom card (purchase progress) */
        .account-dashboard .cards-grid { display:grid; gap:16px; margin-top:22px; grid-template-columns: 1fr; }
        .account-dashboard .card {
            background:#fff; border-radius:16px; overflow:hidden;
            box-shadow:0 2px 12px rgba(0,0,0,0.06); border:1px solid rgba(0,0,0,.06);
        }
        .account-dashboard .card-header { padding:12px 16px; border-bottom:1px solid rgba(0,0,0,.08); font-weight:700; background:#f9fafb; }
        .account-dashboard .card-body { padding:16px; color:#374151; line-height:1.6; }

        /* Custom progress bar */
        .account-dashboard .progress-wrap { margin-top: 8px; }
        .account-dashboard .progress-bar {
            width: 100%; height: 24px; background: #eef2ff; border-radius: 12px; overflow: hidden; position: relative;
            box-shadow: inset 0 0 0 1px rgba(0,0,0,.05);
        }
        .account-dashboard .progress-bar > .fill {
            height: 100%; background: linear-gradient(90deg, #22c55e, #16a34a);
            width: 0%; transition: width .3s ease; color:#fff; font-weight:700; display:flex; align-items:center; justify-content:center;
        }
        .account-dashboard .progress-info { margin-top: 8px; font-size: .95rem; color:#6b7280; }
        .account-dashboard .badge {
            display:inline-block; padding: 4px 8px; border-radius: 999px; background:#ecfeff; color:#0891b2; font-weight:700; font-size:.9rem;
            border: 1px solid rgba(8,145,178,.25);
        }

        /* Top welcome section */
        .account-dashboard .hello { margin-bottom: 10px; }
        .account-dashboard .hello h1 { margin:0 0 4px; font-size: 2rem; font-weight: 800; }
    </style>

    <!-- Welcome message -->
    <div class="hello">
        <h1>Hi <?= h($this->Identity?->get('email') ?? 'User'); ?></h1>
        <div class="muted">Welcome back — manage your account and orders below.</div>
    </div>

    <hr class="divider" />

    <div class="main-grid">

        <!-- Left column: account tiles -->
        <div class="tiles">
            <a class="tile-link" href="<?= $orderHistoryUrl ?>">
                <div class="tile">
                    <div class="icon">📦</div>
                    <div>
                        <h3>Order history →</h3>
                        <p>View your order history and track your orders</p>
                    </div>
                    <div class="open-btn">Open ›</div>
                </div>
            </a>

            <a class="tile-link" href="<?= $editDetailsUrl ?>">
                <div class="tile">
                    <div class="icon">👤</div>
                    <div>
                        <h3>Edit details →</h3>
                        <p>Manage your account details</p>
                    </div>
                    <div class="open-btn">Open ›</div>
                </div>
            </a>

            <a class="tile-link" href="<?= $trackOrderUrl ?>">
                <div class="tile">
                    <div class="icon">🚚</div>
                    <div>
                        <h3>Track your order →</h3>
                        <p>Check a delivery status of an order</p>
                    </div>
                    <div class="open-btn">Open ›</div>
                </div>
            </a>

            <a class="tile-link" href="<?= $myListsUrl ?>">
                <div class="tile">
                    <div class="icon">📋</div>
                    <div>
                        <h3>My lists →</h3>
                        <p>Create, organise and save list of products for easy ordering</p>
                    </div>
                    <div class="open-btn">Open ›</div>
                </div>
            </a>
        </div>

        <!-- Right column -->
        <div>
            <div class="muted" style="margin-bottom:8px;">Responsive cards</div>

            <div class="stats-grid">
                <!-- Account balance card -->
                <div class="stat-card">
                    <div class="icon green">💼</div>
                    <div>
                        <p class="stat-title">Account balance</p>
                        <p class="stat-value">$<?= number_format($accountBalance, 2) ?></p>
                    </div>
                </div>

                <!-- Favorite products card -->
                <div class="stat-card">
                    <div class="icon purple">❤️</div>
                    <div>
                        <p class="stat-title">Favorite products</p>
                        <p class="stat-value"><?= number_format($favoriteProducts) ?></p>
                    </div>
                </div>
            </div>

            <div class="muted" style="margin-top:22px; margin-bottom:8px;">Purchase progress</div>

            <div class="cards-grid">
                <!-- Purchase progress card -->
                <div class="card">
                    <div class="card-header">Purchase progress</div>
                    <div class="card-body">
                        <p>
                            Spend <strong>$<?= number_format($target, 0) ?></strong> to receive a
                            <span class="badge">$<?= number_format($couponValue, 0) ?> coupon</span>.
                        </p>

                        <div class="progress-wrap">
                            <div class="progress-bar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= $percent ?>">
                                <div class="fill" style="width: <?= $percent ?>%;">
                                    <?= $percent ?>%
                                </div>
                            </div>
                        </div>

                        <?php if ($leftAmount > 0): ?>
                            <p class="progress-info">
                                You’ve spent <strong>$<?= number_format($spent, 2) ?></strong>.
                                Only <strong>$<?= number_format($leftAmount, 2) ?></strong> left to unlock your coupon.
                            </p>
                        <?php else: ?>
                            <p class="progress-info" style="color:#16a34a;">
                                🎉 Great! You’ve unlocked the coupon. Check your inbox or coupons page to use it.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
