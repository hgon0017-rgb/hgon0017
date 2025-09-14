<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */

$productsUrl = $this->Url->build(['controller' => 'Products', 'action' => 'dashboard']);
$usersUrl    = $this->Url->build(['controller' => 'Users',    'action' => 'index']);
$contactsUrl = $this->Url->build(['controller' => 'ContactUs','action' => 'index']);
?>
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
