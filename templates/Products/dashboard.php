<?php
/**
 * Products dashboard page with sidebar (Products / Users / Enquiries)
 *
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */

$productsUrl = $this->Url->build(['controller' => 'Products', 'action' => 'dashboard']);
$usersUrl    = $this->Url->build(['controller' => 'Users',    'action' => 'index']);
$contactsUrl = $this->Url->build(['controller' => 'ContactUs','action' => 'index']);
?>

<style>
    /* === Keep exactly the same scale as Users page === */
    .admin-shell { display:grid; grid-template-columns:220px 1fr; gap:20px; max-width:1400px; margin:0 auto; padding:20px; }
    .sidebar { background:#f8fafc; border:1px solid #e5e7eb; border-radius:12px; padding:14px; }
    .sidebar h4 { margin:6px 10px 12px; font-size:18px; }
    .nav-list{ list-style:none; padding:0; margin:0; }
    .nav-list li{ margin:4px 0; }
    .nav-link{ display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; text-decoration:none;
        color:#111827; background:#fff; border:1px solid #e5e7eb; }
    .nav-link.active{ background:#e9efff; border-color:#c7d2fe; font-weight:700; }
    .content-card{ background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:18px; }

    .btn { display:inline-block; padding:6px 10px; border-radius:6px; font-size:12px; text-decoration:none; margin-left:6px; }
    .btn-dark { background:#333; color:#fff; }
    .btn-grey { background:#555; color:#fff; }

    table { width:100%; border-collapse:collapse; font-size:13px; margin-top:15px; }
    th, td { border:1px solid #ccc; padding:8px; }
    thead { background:#f2f2f2; }
</style>

<div class="admin-shell">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h4>Admin</h4>
        <ul class="nav-list">
            <li><a class="nav-link active" href="<?= $productsUrl ?>">🛒 Products</a></li>
            <li><a class="nav-link" href="<?= $usersUrl ?>">👥 Users</a></li>
            <li><a class="nav-link active" href="<?= $contactsUrl ?>">📩Enquiries</a></li>
        </ul>
    </aside>

    <!-- Main content -->
    <main>
        <div class="content-card">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <h3 style="margin:0"><?= __('Products') ?></h3>
                <div>
                    <?= $this->Html->link('+ New Product', ['controller'=>'Products','action'=>'add'], ['class' => 'btn btn-dark']) ?>
                </div>
            </div>

            <table>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('name', 'Name') ?></th>
                    <th><?= $this->Paginator->sort('sku', 'SKU') ?></th>
                    <th><?= $this->Paginator->sort('price', 'Price') ?></th>
                    <th><?= $this->Paginator->sort('stock', 'Stock') ?></th>
                    <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Created') ?></th>
                    <th><?= $this->Paginator->sort('modified', 'Modified') ?></th>
                    <th style="text-align:center;">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($products) || (is_object($products) && method_exists($products,'isEmpty') && $products->isEmpty())): ?>
                    <tr>
                        <td colspan="9" style="text-align:center; color:#6b7280; padding:14px;">No products found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td><?= $this->Number->format($p->id) ?></td>
                            <td><?= h($p->name ?? '—') ?></td>
                            <td><?= h($p->sku ?? '—') ?></td>
                            <td>$<?= $this->Number->precision((float)($p->price ?? 0), 2) ?></td>
                            <td><?= $this->Number->format((int)($p->stock ?? 0)) ?></td>
                            <td><?= h($p->status ?? 'active') ?></td>
                            <td><?= $p->created  ? $p->created->format('Y-m-d H:i')  : '—' ?></td>
                            <td><?= $p->modified ? $p->modified->format('Y-m-d H:i') : '—' ?></td>
                            <td style="text-align:center; white-space:nowrap;">
                                <?= $this->Html->link('Details ↗', ['controller'=>'Products','action'=>'view', $p->id], ['class'=>'btn btn-grey']) ?>
                                <?= $this->Html->link('Edit ✎',    ['controller'=>'Products','action'=>'edit', $p->id], ['class'=>'btn btn-dark']) ?>
                                <?= $this->Form->postLink(
                                    'Delete ✖',
                                    ['controller'=>'Products','action'=>'delete', $p->id],
                                    ['confirm' => 'Are you sure?', 'class' => 'btn', 'style' => 'background:#c00;color:#fff;']
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>

            <div style="margin-top:15px; text-align:center;">
                <?= $this->Paginator->prev('‹') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('›') ?>
            </div>
        </div>
    </main>

</div>
