<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactU> $contactUs
 */
$this->assign('title', 'Customer Enquiries');
$contactsUrl = $this->Url->build(['controller' => 'ContactUs', 'action' => 'index']);
$productsUrl = $this->Url->build(['controller' => 'Products', 'action' => 'add']); // ✅ users/products
$usersUrl    = $this->Url->build(['controller' => 'Users', 'action' => 'index']);
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
            <!--            <li><a class="nav-link" href="--><?php //= $incomeUrl ?><!--">💰 Income</a></li>-->
            <li><a class="nav-link" href="<?= $productsUrl ?>">🛒 Products</a></li>
            <li><a class="nav-link active" href="<?= $usersUrl ?>">👥 Users</a></li>
            <li><a class="nav-link active" href="<?= $contactsUrl ?>"> 📩Enquiries</a></li>
        </ul>
    </aside>

    <!-- Main -->
    <main>
        <div class="content-card">
            <h3>Customer Enquiries</h3>

            <div class="table-responsive">
                <table>
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('full_name', "Name") ?></th>
                        <th><?= $this->Paginator->sort('email', "Email Address") ?></th>
                        <th><?= $this->Paginator->sort('created', "Added On") ?></th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($contactUs as $contact): ?>
                        <tr>
                            <td><?= h($contact->full_name) ?></td>
                            <td><?= h($contact->email) ?></td>
                            <td><?= $contact->created ? $contact->created->format('Y-m-d H:i') : '' ?></td>
                            <td>
                                <?= $this->Html->link('View ↗', ['action' => 'view', $contact->id], ['class'=>'btn btn-grey']) ?>
                                <?= $this->Form->postLink('Delete ✖',
                                    ['action' => 'delete', $contact->id],
                                    ['confirm' => 'Are you sure you want to delete this enquiry?', 'class'=>'btn', 'style'=>'background:#c00;color:#fff;']
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top:15px; text-align:center;">
                <?= $this->Paginator->prev('‹') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('›') ?>
            </div>
        </div>
    </main>
</div>
