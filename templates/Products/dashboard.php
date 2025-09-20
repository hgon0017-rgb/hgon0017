<?php
/**
 * Products dashboard page with sidebar (Products / Users / Enquiries)
 *
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
?>

<!-- Main content -->
<main>
    <div class="content-card">
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <h3 style="margin:0"><?= __('Products') ?></h3>
            <div>
                <?= $this->Html->link(
                    '+ New Product',
                    ['controller' => 'Products', 'action' => 'add'],
                    ['class' => 'btn btn-dark']
                ) ?>
            </div>
        </div>

        <table>
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th><?= $this->Paginator->sort('name', 'Name') ?></th>
                <th><?= $this->Paginator->sort('sku', 'SKU') ?></th>
                <th><?= $this->Paginator->sort('pricing', 'Price') ?></th>
                <th><?= $this->Paginator->sort('stock', 'Stock') ?></th>
                <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                <th><?= $this->Paginator->sort('created', 'Created') ?></th>
                <th><?= $this->Paginator->sort('modified', 'Modified') ?></th>
                <th style="text-align:center;">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($products) || (is_object($products) && method_exists($products, 'isEmpty') && $products->isEmpty())): ?>
                <tr>
                    <td colspan="9" style="text-align:center; color:#6b7280; padding:14px;">
                        No products found.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $this->Number->format($p->id) ?></td>
                        <td><?= h($p->name ?? '—') ?></td>
                        <td><?= h($p->sku ?? '—') ?></td>
                        <td>A$<?= $this->Number->precision((float)($p->pricing ?? 0), 2) ?></td>
                        <td><?= $this->Number->format((int)($p->stock ?? 0)) ?></td>
                        <td><?= h($p->status ?? 'active') ?></td>
                        <td><?= $p->created ? $p->created->format('Y-m-d H:i') : '—' ?></td>
                        <td><?= $p->modified ? $p->modified->format('Y-m-d H:i') : '—' ?></td>
                        <td style="text-align:center; white-space:nowrap;">
                            <?= $this->Html->link(
                                'Details ↗',
                                ['controller' => 'Products', 'action' => 'view', $p->id],
                                ['class' => 'btn btn-grey']
                            ) ?>
                            <?= $this->Html->link(
                                'Edit ✎',
                                ['controller' => 'Products', 'action' => 'edit', $p->id],
                                ['class' => 'btn btn-dark']
                            ) ?>
                            <?= $this->Form->postLink(
                                'Delete ✖',
                                ['controller' => 'Products', 'action' => 'delete', $p->id],
                                [
                                    'confirm' => 'Are you sure?',
                                    'class'   => 'btn',
                                    'style'   => 'background:#c00;color:#fff;'
                                ]
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
