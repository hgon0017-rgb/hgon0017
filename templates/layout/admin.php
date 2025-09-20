<?php
/**
 * Admin Layout
 *
 * @var \App\View\AppView $this
 */
$this->extend('default');
$productsUrl = $this->Url->build(['controller' => 'Products', 'action' => 'dashboard']);
$usersUrl    = $this->Url->build(['controller' => 'Users',    'action' => 'index']);
$contactsUrl = $this->Url->build(['controller' => 'ContactUs','action' => 'index']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?> | Admin</title>

    <?= $this->Html->css('admin') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<div class="admin-shell">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h4>Admin</h4>
        <ul class="nav-list">
            <li>
                <a class="nav-link<?= $this->fetch('active') === 'products' ? ' active' : '' ?>"
                   href="<?= $productsUrl ?>">🛒 Products</a>
            </li>
            <li>
                <a class="nav-link<?= $this->fetch('active') === 'users' ? ' active' : '' ?>"
                   href="<?= $usersUrl ?>">👥 Users</a>
            </li>
            <li>
                <a class="nav-link<?= $this->fetch('active') === 'contacts' ? ' active' : '' ?>"
                   href="<?= $contactsUrl ?>">📩 Enquiries</a>
            </li>
        </ul>
    </aside>


    <!-- Main Content -->
    <main>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>
</div>
</body>
</html>
