<?php
/**
 * templates/Users/income.php
 * Income page with the same left sidebar (Income / Product / Users)
 *
 * @var \App\View\AppView $this
 */

// Sidebar links
$incomeUrl   = $this->Url->build(['controller' => 'Users', 'action' => 'income']);   // current
$productsUrl = $this->Url->build(['controller' => 'Users', 'action' => 'products']);
$usersUrl    = $this->Url->build(['controller' => 'Users', 'action' => 'index']);

// (Optional) Static demo numbers — replace with real data from controller if you have them
$totalIncome   = 46760.89;
$thisMonth     = 4200.00;
$orderCount    = 376;
$newCustomers  = 58;
$currentSales  = 65;   // progress current value
$targetSales   = 100;  // progress target value
$progressPct   = $targetSales > 0 ? max(0, min(100, round($currentSales / $targetSales * 100))) : 0;
?>
<style>
    .admin-shell { display:grid; grid-template-columns:220px 1fr; gap:20px; max-width:1400px; margin:0 auto; padding:20px; }
    .sidebar { background:#f8fafc; border:1px solid #e5e7eb; border-radius:12px; padding:14px; }
    .sidebar h4 { margin:6px 10px 12px; font-size:18px; }
    .nav-list{ list-style:none; padding:0; margin:0; }
    .nav-list li{ margin:4px 0; }
    .nav-link{ display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; text-decoration:none;
        color:#111827; background:#fff; border:1px solid #e5e7eb; }
    .nav-link.active{ background:#e9efff; border-color:#c7d2fe; font-weight:700; }

    .content-card{ background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:20px; }
    .income-grid{ display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px; }
    .stat-card{ background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px; padding:18px; text-align:center; }
    .stat-card h3{ margin:0; font-size:28px; font-weight:700; color:#111827; }
    .stat-card p{ margin:6px 0 0; font-size:14px; color:#6b7280; }

    .section{ margin-top:20px; }
    .progress-wrap h4{ margin:0 0 8px; }
    .progress-bar{ width:100%; height:16px; background:#e5e7eb; border-radius:8px; overflow:hidden; }
    .progress-fill{ height:100%; background:#4f46e5; width:<?= $progressPct ?>%; transition:width .3s; }
    .muted{ color:#6b7280; font-size:13px; }
</style>

<div class="admin-shell">

    <!-- Sidebar (same as Users page) -->
    <aside class="sidebar">
        <h4>Admin</h4>
        <ul class="nav-list">
            <li><a class="nav-link active" href="<?= $incomeUrl ?>">💰 Income</a></li>
            <li><a class="nav-link" href="<?= $productsUrl ?>">🛒 Products</a></li>
            <li><a class="nav-link" href="<?= $usersUrl ?>">👥 Users</a></li>
        </ul>
    </aside>

    <!-- Right content -->
    <main>
        <div class="content-card">
            <h2 style="margin-top:0;">Income Overview</h2>
            <p class="muted">View revenue and sales performance at a glance.</p>

            <div class="income-grid">
                <div class="stat-card">
                    <h3>$<?= number_format($totalIncome, 2) ?></h3>
                    <p>Total Income</p>
                </div>
                <div class="stat-card">
                    <h3>$<?= number_format($thisMonth, 2) ?></h3>
                    <p>This Month</p>
                </div>
                <div class="stat-card">
                    <h3><?= number_format($orderCount) ?></h3>
                    <p>Orders</p>
                </div>
                <div class="stat-card">
                    <h3><?= number_format($newCustomers) ?></h3>
                    <p>New Customers</p>
                </div>
            </div>

            <div class="section progress-wrap">
                <h4>🎁 Sales Reward Progress</h4>
                <p class="muted">Spend $<?= number_format($targetSales) ?> to earn a $10 coupon</p>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <p class="muted" style="margin-top:6px;">
                    Progress: $<?= number_format($currentSales, 2) ?> / $<?= number_format($targetSales, 2) ?> (<?= $progressPct ?>%)
                </p>
            </div>
        </div>
    </main>

</div>
