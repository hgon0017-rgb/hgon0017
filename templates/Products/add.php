<?php
/**
 * templates/Products/add.php
 *
 * Add Product page with Admin sidebar (Products / Users / Enquiries)
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>

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
            <?= $this->Form->control('image_path', [
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
