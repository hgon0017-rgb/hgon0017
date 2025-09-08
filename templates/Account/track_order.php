<?php
/**
 * @var \App\View\AppView $this
 * @var array|null $order
 */
$this->assign('title', 'Track your order');
?>
<style>
    :root{--bg:#f6f7fb;--card:#fff;--ring:#e9e9ee;--muted:#6b7280;--text:#111827;--primary:#000;--primary-2:#222}
    .page{background:var(--bg);padding:24px 16px 48px}
    .wrap{max-width:900px;margin:0 auto}
    .card{background:var(--card);border:1px solid var(--ring);border-radius:14px;box-shadow:0 10px 28px rgba(0,0,0,.06);overflow:hidden}
    .hd{padding:20px;border-bottom:1px solid var(--ring);display:flex;justify-content:space-between;align-items:center}
    .hd h2{margin:0;font-weight:900;color:var(--text);font-size:22px}
    .body{padding:20px}
    label{display:block;margin-bottom:6px;font-weight:800;color:var(--text)}
    input{width:100%;padding:12px;border:1px solid var(--ring);border-radius:10px;outline:none}
    input:focus{box-shadow:0 0 0 3px rgba(0,0,0,.12)}
    .actions{margin-top:12px;display:flex;gap:10px}
    .kv{display:grid;grid-template-columns:160px 1fr;gap:8px;margin-top:14px}
    .badge{display:inline-block;border:1px solid var(--ring);border-radius:999px;padding:3px 10px;font-size:12px}

    .acc-btn{display:inline-flex;gap:6px;align-items:center;padding:10px 14px;border:1px solid var(--ring);border-radius:10px;background:#fff;
        text-decoration:none;color:var(--text);font-weight:800;cursor:pointer}
    .acc-btn:hover{background:#fafafa}
    .acc-btn-primary{background:var(--primary);border-color:var(--primary);color:#fff}
    .acc-btn-primary:hover{background:var(--primary-2)}
</style>

<div class="page">
    <div class="wrap">
        <div class="card">
            <div class="hd">
                <h2>Track your order</h2>
                <?= $this->Html->link('← Back to Account',['action'=>'dashboard'],['class'=>'acc-btn']) ?>
            </div>
            <div class="body">
                <?= $this->Form->create(null,['url'=>['action'=>'trackOrder']]) ?>
                <label>Order number</label>
                <?= $this->Form->control('order_no',['label'=>false,'placeholder'=>'e.g. 101']) ?>
                <div class="actions">
                    <?= $this->Form->button('Track order',['class'=>'acc-btn acc-btn-primary']) ?>
                    <?= $this->Html->link('Clear',['action'=>'trackOrder'],['class'=>'acc-btn']) ?>
                </div>
                <?= $this->Form->end() ?>

                <?php if (!empty($order)): ?>
                    <div class="kv">
                        <div>Order #</div><div><?= h($order['id']) ?></div>
                        <div>Date</div><div><?= h($order['date']) ?></div>
                        <div>Status</div><div><span class="badge"><?= h($order['status']) ?></span></div>
                    </div>
                <?php elseif ($this->request->is('post')): ?>
                    <div style="color:#6b7280;margin-top:12px">No order found with that number.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
