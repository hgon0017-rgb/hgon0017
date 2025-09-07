<?php
/**
 * Users index page with sidebar (Income / Products / Users only)
 *
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */

$dashboardUrl = $this->Url->build(['controller' => 'Admin', 'action' => 'dashboard']);
$productsUrl  = $this->Url->build(['controller' => 'Users', 'action' => 'products']);
$usersUrl     = $this->Url->build(['controller' => 'Users', 'action' => 'index']);
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
            <!-- 把 Dashboard 改成 收入 -->
            <li><a class="nav-link" href="<?= $dashboardUrl ?>">💰 Income</a></li>
            <li><a class="nav-link" href="<?= $productsUrl ?>">🛒 Products</a></li>
            <li><a class="nav-link active" href="<?= $usersUrl ?>">👥 Users</a></li>
        </ul>
    </aside>

    <!-- Main content -->
    <main>
        <div class="content-card">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <h3 style="margin:0"><?= __('Users') ?></h3>
                <div>
                    <!-- 保留 New User，删除 Product 按钮 -->
                    <?= $this->Html->link('+ New User', ['action'=>'add'], ['class'=>'btn btn-dark']) ?>
                </div>
            </div>

            <table>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('email', 'Email') ?></th>
                    <th><?= $this->Paginator->sort('role', 'Role') ?></th>
                    <th><?= $this->Paginator->sort('nonce', 'Nonce') ?></th>
                    <th><?= $this->Paginator->sort('nonce_expiry', 'Expiry') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Created') ?></th>
                    <th><?= $this->Paginator->sort('modified', 'Modified') ?></th>
                    <th style="text-align:center;">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $this->Number->format($user->id) ?></td>
                        <td><?= h($user->email) ?></td>
                        <td><?= h($user->role) ?></td>
                        <td><?= h($user->nonce) ?></td>
                        <td><?= h($user->nonce_expiry) ?></td>
                        <td><?= $user->created ? $user->created->format('Y-m-d H:i') : '' ?></td>
                        <td><?= $user->modified ? $user->modified->format('Y-m-d H:i') : '' ?></td>
                        <td style="text-align:center;">
                            <?= $this->Html->link('Details ↗', ['action'=>'view', $user->id], ['class'=>'btn btn-grey']) ?>
                            <?= $this->Html->link('Edit ✎', ['action'=>'edit', $user->id], ['class'=>'btn btn-dark']) ?>
                            <?= $this->Form->postLink('Delete ✖', ['action'=>'delete', $user->id], [
                                'confirm'=>'Are you sure?',
                                'class'=>'btn',
                                'style'=>'background:#c00;color:#fff;'
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
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
