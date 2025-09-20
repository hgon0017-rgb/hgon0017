<?php
/**
 * Product detail page (Admin style, same scale as Users)
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>

<div class="content-card">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:10px;">
        <h3 style="margin:0"><?= h($product->name ?? '—') ?></h3>
        <div>
            <?= $this->Html->link('Edit ✎', ['action' => 'edit', $product->id], ['class'=>'btn btn-dark']) ?>
            <?= $this->Form->postLink(
                'Delete ✖',
                ['action' => 'delete', $product->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $product->id), 'class'=>'btn btn-danger']
            ) ?>
            <?= $this->Html->link('← Back to Products', ['action' => 'dashboard'], ['class'=>'btn btn-grey']) ?>
        </div>
    </div>

    <table>
        <tbody>
        <tr>
            <th style="width:180px;">ID</th>
            <td><?= $this->Number->format($product->id) ?></td>
        </tr>
        <tr>
            <th>Name</th>
            <td><?= h($product->name ?? '—') ?></td>
        </tr>
        <tr>
            <th>SKU</th>
            <td><?= h($product->sku ?? '—') ?></td>
        </tr>
        <tr>
            <th>Price (A$)</th>
            <td>$<?= $this->Number->precision((float)($product->pricing ?? 0), 2) ?></td>
        </tr>
        <tr>
            <th>Stock</th>
            <td><?= $this->Number->format((int)($product->stock ?? 0)) ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= h($product->status ?? '—') ?></td>
        </tr>
        <tr>
            <th>Category</th>
            <td><?= h($product->category ?? '—') ?></td>
        </tr>
        <tr>
            <th>Discount (%)</th>
            <td><?= $this->Number->precision((float)($product->discount ?? 0), 2) ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?= nl2br(h($product->description ?? '—')) ?></td>
        </tr>
        <tr>
            <th>Image</th>
            <td>
                <?php if (!empty($product->image_path)): ?>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <?= $this->Html->image($product->image_path, [
                            'class'=>'preview',
                            'alt'=>h($product->name ?? '—')
                        ]) ?>
                        <span class="muted"><?= h($product->image_path) ?></span>
                    </div>
                <?php else: ?>
                    <span class="muted">—</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Created</th>
            <td><?= $product->created ? $product->created->format('Y-m-d H:i') : '—' ?></td>
        </tr>
        <tr>
            <th>Modified</th>
            <td><?= $product->modified ? $product->modified->format('Y-m-d H:i') : '—' ?></td>
        </tr>
        </tbody>
    </table>
</div>
