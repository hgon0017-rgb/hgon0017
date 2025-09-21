<?php
/**
 * templates/Products/index.php
 * Product grid with "Add to cart" that jumps to Pages/cart.php.
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
$this->assign('title', 'Product Showcase');
?>

<style>
    /* top bar */
    .filter-bar {display:flex;justify-content:space-between;align-items:center;margin:20px 0;flex-wrap:wrap}
    .filters {display:flex;gap:10px;flex-wrap:wrap}
    .filters button, .filters select {
        padding:6px 12px;border:1px solid #ccc;background:#fff;
        border-radius:6px;cursor:pointer;font-size:13px;transition:.2s
    }
    .filters button:hover, .filters select:hover {background:#f4f4f4}
    .search-box {flex:1;max-width:280px;margin-left:auto}
    .search-box input {
        width:100%;padding:8px 12px;border:1px solid #ccc;
        border-radius:20px;font-size:14px
    }

    /* grid */
    .products-grid {
        display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
        gap:20px;margin-top:10px
    }
    .product-card {
        border:1px solid #e5e7eb;border-radius:12px;background:#fff;
        overflow:hidden;transition:transform .2s,box-shadow .2s;position:relative
    }
    .product-card:hover {transform:translateY(-4px);box-shadow:0 8px 24px rgba(0,0,0,.08)}
    .product-card img {width:100%;height:180px;object-fit:contain;background:#f9f9f9}
    .sale-badge {
        position:absolute;top:10px;left:10px;background:#111;color:#fff;
        padding:3px 6px;font-size:12px;border-radius:4px
    }
    .product-info {padding:12px}
    .product-title {font-size:15px;font-weight:700;margin:6px 0}
    .price {font-weight:700;color:#111;font-size:14px}
    .old-price {text-decoration:line-through;color:#888;margin-left:8px;font-size:12px}

    /* actions */
    .card-actions {
        display:flex;justify-content:space-between;align-items:center;
        padding:12px;border-top:1px solid #f1f2f6
    }
    .qty-select {width:56px;border:1px solid #e5e7eb;border-radius:8px;padding:6px 8px}
    .btn-cart {
        display:inline-flex;align-items:center;gap:8px;background:#111827;color:#fff;
        border:none;border-radius:10px;padding:10px 14px;cursor:pointer
    }
    .btn-cart:hover {filter:brightness(1.05);transform:translateY(-1px)}
</style>

<div class="filter-bar">
    <div class="filters">
        <button type="button">On sale</button>
        <span><?= $products->count() ?> products</span>
    </div>
    <div class="search-box">
        <input type="text" placeholder="Search products...">
    </div>
</div>





<div class="products-grid">
    <?php foreach ($products as $p): ?>
        <?php
        $cartUrl = $this->Url->build([
            'controller' => 'Pages',
            'action'     => 'display',
            'cart',
        ]);
        $formId = 'to-cart-' . (int)$p->id;
        ?>
        <div class="product-card">
            <?php if ($p->discount > 0): ?>
                <div class="sale-badge"><?= h($p->discount) ?>% off</div>
            <?php endif; ?>

            <?= $this->Html->image($p->image_path, [
                'alt' => $p->name,
                'class' => 'product-img'
            ]) ?>


            <div class="product-info">
                <div class="product-title"><?= h($p->name) ?></div>
                <div class="price">
                    A$<?= number_format($p->pricing, 2) ?>
                    <?php if ($p->discount > 0): ?>
                        <span class="old-price">
                            A$<?= number_format($p->pricing * (100 + $p->discount) / 100, 2) ?>
                        </span>
                    <?php endif; ?>
                </div>
                <?php if (!empty($p->rating) && !empty($p->reviews)): ?>
                    <div class="rating">⭐ <?= h($p->rating) ?> (<?= h($p->reviews) ?>)</div>
                <?php endif; ?>
            </div>

            <div class="card-actions">
                <?php if ($p->stock > 0): ?>
                    <!-- Quantity selector -->
                    <select class="qty-select" form="<?= $formId ?>" name="qty">
                        <?php for ($q=1; $q<=10; $q++): ?>
                            <option value="<?= $q ?>"><?= $q ?></option>
                        <?php endfor; ?>
                    </select>

                    <form id="<?= $formId ?>" method="get" action="<?= $cartUrl ?>">
                        <input type="hidden" name="id"    value="<?= (int)$p->id ?>">
                        <input type="hidden" name="name"  value="<?= h($p->name) ?>">
                        <input type="hidden" name="price" value="<?= (float)$p->pricing ?>">
                        <input type="hidden" name="image" value="<?= h($p->image_path) ?>">

                        <button type="submit" class="btn-cart" aria-label="Add to cart">
                            <span>🛒</span> Add to cart
                        </button>
                    </form>
                <?php else: ?>
                    <span style="color:red;font-weight:bold;">Out of Stock</span>
                <?php endif; ?>
            </div>

        </div>
    <?php endforeach; ?>
</div>
