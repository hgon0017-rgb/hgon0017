<?php
/**
 * Product detail page (Admin style, same scale as Users)
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */

$name      = $product->name ?? '—';
$sku       = $product->sku  ?? '—';
$status    = $product->status ?? '—';
$imagePath = $product->image_path ?? null;
?>

<div class="content-card">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:10px;">
        <h3 style="margin:0"><?= h($name) ?></h3>
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
            <td><?= h($name) ?></td>
        </tr>
        <tr>
            <th>SKU</th>
            <td><?= h($sku) ?></td>
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
            <td><?= h($status) ?></td>
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
            <td><?= nl2br(h($product->description ?? '')) ?></td>
        </tr>
        <tr>
            <th>Image</th>
            <td>
                <?php if ($imagePath): ?>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <?= $this->Html->image($imagePath, ['class'=>'preview', 'alt'=>h($name)]) ?>
                        <span class="muted"><?= h($imagePath) ?></span>
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
