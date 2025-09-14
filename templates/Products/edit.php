<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */

$productsUrl = $this->Url->build(['controller' => 'Products', 'action' => 'dashboard']);
$usersUrl    = $this->Url->build(['controller' => 'Users',    'action' => 'index']);
$contactsUrl = $this->Url->build(['controller' => 'ContactUs','action' => 'index']);
?>

<style>
    .admin-shell { display:grid; grid-template-columns:220px 1fr; gap:20px; max-width:1400px; margin:0 auto; padding:20px; }
    .sidebar { background:#f8fafc; border:1px solid #e5e7eb; border-radius:12px; padding:14px; }
    .sidebar h4 { margin:6px 10px 12px; font-size:18px; }
    .nav-list{ list-style:none; padding:0; margin:0; }
    .nav-list li{ margin:4px 0; }
    .nav-link{ display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; text-decoration:none;
        color:#111827; background:#fff; border:1px solid #e5e7eb; }
    .nav-link.active{ background:#e9efff; border-color:#c7d2fe; font-weight:700; }
    .content-card{ background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:18px; }

    form .input { margin-bottom:14px; }
    label { font-weight:600; display:block; margin-bottom:6px; }
    input[type="text"], input[type="number"], textarea {
        width:100%; padding:8px 10px; border:1px solid #ccc; border-radius:6px; font-size:14px;
    }
    textarea { min-height:80px; }
    .btn { display:inline-block; padding:8px 14px; border-radius:6px; font-size:13px; text-decoration:none; margin-right:6px; }
    .btn-dark { background:#333; color:#fff; }
    .btn-danger { background:#c00; color:#fff; }
</style>

<div class="admin-shell">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h4>Admin</h4>
        <ul class="nav-list">
            <li><a class="nav-link active" href="<?= $productsUrl ?>">🛒 Products</a></li>
            <li><a class="nav-link" href="<?= $usersUrl ?>">👥 Users</a></li>
            <li><a class="nav-link" href="<?= $contactsUrl ?>">📩 Enquiries</a></li>
        </ul>
    </aside>

    <!-- Main content -->
    <main>
        <div class="content-card">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <h3 style="margin:0">Edit Product</h3>
                <div>
                    <?= $this->Form->postLink(
                        'Delete ✖',
                        ['action' => 'delete', $product->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $product->id), 'class' => 'btn btn-danger']
                    ) ?>
                    <?= $this->Html->link('← Back to Products', ['action' => 'dashboard'], ['class'=>'btn']) ?>
                </div>
            </div>

            <div style="margin-top:18px;">
                <?= $this->Form->create($product) ?>
                <fieldset>
                    <?php
                    echo $this->Form->control('name',        ['label'=>'Product Name']);
                    echo $this->Form->control('description', ['label'=>'Description', 'type'=>'textarea']);
                    echo $this->Form->control('pricing',     ['label'=>'Price (A$)']);
                    echo $this->Form->control('image_path',  ['label'=>'Image Path']);
                    echo $this->Form->control('stock',       ['label'=>'Stock']);
                    echo $this->Form->control('category',    ['label'=>'Category']);
                    echo $this->Form->control('discount',    ['label'=>'Discount (%)']);
                    ?>
                </fieldset>
                <div style="margin-top:14px;">
                    <?= $this->Form->button(__('Save Changes'), ['class'=>'btn btn-dark']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </main>

</div>
