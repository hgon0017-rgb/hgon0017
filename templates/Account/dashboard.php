<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'My Account');

// 取当前登录邮箱（兼容没装 Authentication 的情况）
$userEmail = '';
if (method_exists($this, 'Identity') && $this->Identity?->isLoggedIn()) {
    $userEmail = (string)$this->Identity->get('email');
} elseif (isset($user) && !empty($user->email)) {
    $userEmail = (string)$user->email;
}
?>
<style>
    :root{
        --bg:#f6f7fb;--card:#fff;--ring:#e9e9ee;--muted:#6b7280;--text:#111827;
        --primary:#000;--primary-2:#222;
    }
    .acc-wrap{background:var(--bg);padding:28px 18px 56px}
    .acc-container{max-width:1200px;margin:0 auto}
    .acc-head{
        display:flex;align-items:center;justify-content:space-between;gap:12px;
        border-bottom:1px solid var(--ring);padding:12px 2px 18px;margin-bottom:18px;
    }
    .acc-title{margin:0;font-size:28px;font-weight:900;color:var(--text)}
    .acc-sub{color:var(--muted);margin-top:6px;font-size:14px}

    .acc-grid{
        display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-top:12px;
    }
    @media (max-width:900px){.acc-grid{grid-template-columns:1fr}}
    .acc-card{
        background:var(--card);border:1px solid var(--ring);border-radius:16px;
        padding:18px 18px 16px;display:flex;gap:16px;box-shadow:0 8px 22px rgba(0,0,0,.06);
        transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease;
        position:relative;overflow:hidden;
    }
    .acc-card:hover{transform:translateY(-2px);box-shadow:0 14px 28px rgba(0,0,0,.09);border-color:#dfe2ea}
    .acc-ico{
        min-width:44px;height:44px;border-radius:12px;border:1px solid var(--ring);
        display:grid;place-items:center;background:#fafafa;
    }
    .acc-ico svg{width:22px;height:22px;color:#111}
    .acc-body{flex:1 1 auto}
    .acc-body h3{
        margin:0 0 6px;font-size:26px;font-weight:900;color:var(--text);letter-spacing:.2px;
    }
    .acc-body p{margin:0;color:#3f4755}
    .acc-foot{margin-top:14px}
    .acc-btn{
        display:inline-flex;gap:8px;align-items:center;
        padding:9px 14px;border:1px solid var(--ring);border-radius:10px;
        background:#fff;color:#111;text-decoration:none;font-weight:800;
    }
    .acc-btn:hover{background:#f6f6f6}
    .acc-btn .chev{transition:transform .16s ease}
    .acc-btn:hover .chev{transform:translateX(2px)}
    /* 小的“Go”链接风格（可删） */
    .acc-go{margin-top:8px;display:inline-block;color:#111;font-weight:700}
    .acc-go:hover{text-decoration:underline}
</style>

<div class="acc-wrap">
    <div class="acc-container">

        <div class="acc-head">
            <div>
                <h1 class="acc-title">Hi <?= h($userEmail ?: 'there') ?></h1>
                <div class="acc-sub">Welcome back — manage your account and orders below.</div>
            </div>
        </div>

        <div class="acc-grid">

            <!-- Orders -->
            <div class="acc-card">
                <div class="acc-ico">
                    <!-- box icon -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        <polyline points="3.27 6.96 12 12 20.73 6.96"/>
                        <line x1="12" y1="22" x2="12" y2="12"/>
                    </svg>
                </div>
                <div class="acc-body">
                    <h3>Order history →</h3>
                    <p>View your order history and track your orders</p>
                    <div class="acc-foot">
                        <?= $this->Html->link('Open ' . '<span class="chev">›</span>', ['action'=>'orders'], [
                            'class'=>'acc-btn','escape'=>false
                        ]) ?>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="acc-card">
                <div class="acc-ico">
                    <!-- user icon -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="acc-body">
                    <h3>Edit details →</h3>
                    <p>Manage your account details</p>
                    <div class="acc-foot">
                        <?= $this->Html->link('Open ' . '<span class="chev">›</span>', ['action'=>'details'], [
                            'class'=>'acc-btn','escape'=>false
                        ]) ?>
                    </div>
                </div>
            </div>

            <!-- Track order -->
            <div class="acc-card">
                <div class="acc-ico">
                    <!-- truck icon -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 17h4a1 1 0 0 0 1-1V6H3v10a1 1 0 0 0 1 1h1"/>
                        <path d="M15 6h3l3 4v6a1 1 0 0 1-1 1h-1"/>
                        <circle cx="7.5" cy="17.5" r="1.5"/>
                        <circle cx="17.5" cy="17.5" r="1.5"/>
                    </svg>
                </div>
                <div class="acc-body">
                    <h3>Track your order →</h3>
                    <p>Check a delivery status of an order</p>
                    <div class="acc-foot">
                        <?= $this->Html->link('Open ' . '<span class="chev">›</span>', ['action'=>'trackOrder'], [
                            'class'=>'acc-btn','escape'=>false
                        ]) ?>
                    </div>
                </div>
            </div>

            <!-- Lists -->
            <div class="acc-card">
                <div class="acc-ico">
                    <!-- list icon -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6"/>
                        <line x1="8" y1="12" x2="21" y2="12"/>
                        <line x1="8" y1="18" x2="21" y2="18"/>
                        <circle cx="4" cy="6" r="1"/>
                        <circle cx="4" cy="12" r="1"/>
                        <circle cx="4" cy="18" r="1"/>
                    </svg>
                </div>
                <div class="acc-body">
                    <h3>My lists →</h3>
                    <p>Create, organise and save list of products for easy ordering</p>
                    <div class="acc-foot">
                        <?= $this->Html->link('Open ' . '<span class="chev">›</span>', ['action'=>'lists'], [
                            'class'=>'acc-btn','escape'=>false
                        ]) ?>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
