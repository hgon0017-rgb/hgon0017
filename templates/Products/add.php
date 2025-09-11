<?php
/**
 * templates/Products/add.php
 *
 * Add Product page with Admin sidebar (Income / Products / Users)
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */

// Sidebar URLs
$incomeUrl   = $this->Url->build(['controller' => 'Users', 'action' => 'income']);
$usersUrl    = $this->Url->build(['controller' => 'Users', 'action' => 'index']);
$productsUrl = $this->Url->build(['controller' => 'Products', 'action' => 'index']);
?>

<style>
    /* Layout container */
    .admin-shell {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 20px;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Sidebar styling */
    .sidebar {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 14px;
    }
    .sidebar h4 { margin: 6px 10px 12px; font-size: 18px; }
    .nav-list { list-style: none; padding: 0; margin: 0; }
    .nav-list li { margin: 4px 0; }
    .nav-link {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 12px; border-radius: 10px; text-decoration: none;
        color: #111827; background: #fff; border: 1px solid #e5e7eb;
    }
    .nav-link.active { background: #e9efff; border-color: #c7d2fe; font-weight: 700; }

    /* Content card */
    .content-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px;
    }
    .card-head {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 12px;
    }

    /* Buttons */
    .btn { display: inline-block; padding: 8px 12px; border-radius: 8px; font-size: 13px; text-decoration: none; }
    .btn-dark { background: #333; color: #fff; }
    .btn-grey { background: #555; color: #fff; }

    /* Form grid */
    form.product-form { max-width: 760px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-row-full { grid-column: 1 / -1; }

    .form-label { display: block; margin: 6px 0 4px; font-size: 13px; color: #374151; }
    .form-input, .form-textarea {
        width: 100%; padding: 10px 12px;
        border: 1px solid #d1d5db; border-radius: 10px;
        font-size: 14px; background: #fff;
    }
    .form-textarea { min-height: 120px; resize: vertical; }

    .form-actions { margin-top: 16px; display: flex; gap: 10px; }
    .muted { color: #6b7280; font-size: 13px; }
</style>

<div class="admin-shell">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h4>Admin</h4>
        <ul class="nav-list">
            <li><a class="nav-link" href="<?= $incomeUrl ?>">💰 Income</a></li>
            <li><a class="nav-link active" href="<?= $productsUrl ?>">🛒 Products</a></li>
            <li><a class="nav-link" href="<?= $usersUrl ?>">👥 Users</a></li>
        </ul>
    </aside>

    <!-- Main content -->
    <main>
        <div class="content-card">
            <div class="card-head">
                <h3 style="margin:0;">Add Product</h3>
                <!-- Back button -->
                <?= $this->Html->link('← Back to Products', ['action' => 'index'], ['class' => 'btn btn-grey']) ?>
            </div>

            <!-- Add Product Form -->
            <?= $this->Form->create($product, ['class' => 'product-form', 'type' => 'file']) ?>


            <div class="form-grid">

                <!-- Product Name -->
                <div>
                    <label class="form-label">Product Name</label>
                    <?= $this->Form->control('name', [
                        'label' => false,
                        'class' => 'form-input',
                        'placeholder' => 'e.g. Custom Flag'
                    ]) ?>
                </div>

                <!-- Category -->
                <div>
                    <label class="form-label">Category</label>
                    <?= $this->Form->control('category', [
                        'label' => false,
                        'class' => 'form-input',
                        'placeholder' => 'e.g. Banner / Poster / Flag'
                    ]) ?>
                </div>

                <!-- Description -->
                <div class="form-row-full">
                    <label class="form-label">Description</label>
                    <?= $this->Form->control('description', [
                        'type' => 'textarea',
                        'label' => false,
                        'class' => 'form-textarea',
                        'placeholder' => 'Short description of the product'
                    ]) ?>
                </div>

                <!-- Pricing -->
                <div>
                    <label class="form-label">Price (A$)</label>
                    <?= $this->Form->control('pricing', [
                        'type' => 'number',
                        'step' => '0.01',
                        'min' => '0',
                        'label' => false,
                        'class' => 'form-input',
                        'placeholder' => 'e.g. 29.99'
                    ]) ?>
                </div>

                <!-- Discount -->
                <div>
                    <label class="form-label">Discount (%)</label>
                    <?= $this->Form->control('discount', [
                        'type' => 'number',
                        'step' => '1',
                        'min' => '0',
                        'max' => '100',
                        'label' => false,
                        'class' => 'form-input',
                        'placeholder' => 'e.g. 10'
                    ]) ?>
                </div>

                <!-- Stock -->
                <div>
                    <label class="form-label">Stock</label>
                    <?= $this->Form->control('stock', [
                        'type' => 'number',
                        'step' => '1',
                        'min' => '0',
                        'label' => false,
                        'class' => 'form-input',
                        'placeholder' => 'e.g. 100'
                    ]) ?>
                </div>

                <!-- Image upload -->
                <div>
                    <label class="form-label">Image Path</label>
                    <?= $this->Form->control('image', [
                        'type' => 'file',
                        'label' => false,
                        'class' => 'form-input'
                    ]) ?>

                </div>
            </div>

            <!-- Submit & Cancel -->
            <div class="form-actions">
                <?= $this->Form->button('Save Product', ['class' => 'btn btn-dark']) ?>
                <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-grey']) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </main>
</div>


