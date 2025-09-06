<?php
/**
 * @var \App\View\AppView $this
 * @var array|\Cake\Datasource\ResultSetInterface|null $orders
 */
$this->assign('title', 'Order history');
$orders = $orders ?? [
    // 没接数据库时的示例数据；接上 DB 后可删除这几行
    ['id'=>101,'order_no'=>101,'date'=>'2025-09-01','items_count'=>null,'total'=>null,'status'=>'Shipped'],
    ['id'=>102,'order_no'=>102,'date'=>'2025-09-05','items_count'=>null,'total'=>null,'status'=>'Processing'],
];
?>
<style>
    :root{--bg:#f6f7fb;--card:#fff;--ring:#e9e9ee;--muted:#6b7280;--text:#111827;--ok:#16a34a;--warn:#b45309}
    .page{background:var(--bg);padding:24px 16px 48px}
    .wrap{max-width:1100px;margin:0 auto}
    .card{background:var(--card);border:1px solid var(--ring);border-radius:14px;box-shadow:0 10px 28px rgba(0,0,0,.06);overflow:hidden}
    .hd{padding:20px;border-bottom:1px solid var(--ring);display:flex;justify-content:space-between;align-items:center}
    .hd h2{margin:0;font-weight:900;color:var(--text);font-size:22px}
    .body{padding:18px}
    .table{width:100%;border-collapse:separate;border-spacing:0;font-size:14px}
    .table th,.table td{padding:12px 10px;border-bottom:1px solid var(--ring);text-align:left}
    .table thead th{background:#fbfbfd;color:#374151;font-weight:800}
    .badge{display:inline-block;border-radius:999px;padding:4px 12px;font-size:12px}
    .badge.ok{background:#ecfdf5;color:#065f46;border:1px solid #c8f4d1}
    .badge.warn{background:#fffbeb;color:#7c2d12;border:1px solid #fdecc8}
    .empty{color:var(--muted);padding:8px 2px}

    .acc-btn{display:inline-flex;gap:6px;align-items:center;padding:8px 12px;border:1px solid var(--ring);border-radius:10px;background:#fff;
        text-decoration:none;color:var(--text);font-weight:700}
    .acc-btn:hover{background:#fafafa}
</style>

<div class="page">
    <div class="wrap">
        <div class="card">
            <div class="hd">
                <h2>Order history</h2>
                <?= $this->Html->link('← Back to Account', ['action'=>'dashboard'], ['class'=>'acc-btn']) ?>
            </div>
            <div class="body">
                <?php if (!empty($orders)): ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th style="width:1%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $o): ?>
                            <tr>
                                <td><?= h($o['order_no'] ?? $o['id']) ?></td>
                                <td><?= h($o['date'] ?? ($o['created'] ?? '')) ?></td>
                                <td><?= h($o['items_count'] ?? '—') ?></td>
                                <td><?= h(isset($o['total']) ? sprintf('$%.2f',(float)$o['total']) : '—') ?></td>
                                <td>
                                    <?php $status = strtolower((string)($o['status'] ?? 'processing')); ?>
                                    <span class="badge <?= in_array($status,['shipped','completed'])?'ok':'warn' ?>">
                      <?= h(ucfirst($status)) ?>
                    </span>
                                </td>
                                <td><?= $this->Html->link('View', ['controller'=>'Orders','action'=>'view',$o['id']], ['class'=>'acc-btn']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty">No orders found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
