<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * @var \App\View\AppView $this
 */
$cakeDescription = 'CakePHP: the rapid development php framework';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($this->fetch('title')) ?></title>
    <?= $this->fetch('meta') . $this->fetch('default') . $this->fetch('script') ?>
    <?= $this->Html->css('default') ?>
</head>
<body>

<header class="navbar">
    <div class="nav-left">
        <?= $this->Html->image('Iconic Prints.png', [
            'alt' => 'Iconic Prints Logo',
            'class' => 'site-logo'
        ]) ?>

        <?= $this->Html->link('Dashboard', '/', []) ?>
        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'about']) ?>">About</a>
        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'index']) ?>">Products</a>
        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'help']) ?>">Help</a>
    </div>

    <div class="nav-right">
        <?php if ($this->Identity->isLoggedIn()): ?>
            <!--AdminUsers/index -->
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>">Admin</a>
            <?= $this->Form->postLink(
                'Logout',
                ['controller'=>'Auth','action'=>'logout','prefix'=>false],
                ['class'=>'btn','form'=>['class'=>'inline']]
            ) ?>
        <?php else: ?>
            <?= $this->Html->link(
                'Login or Register ➜',
                ['controller'=>'Auth','action'=>'login','prefix'=>false],
                ['class'=>'btn']
            ) ?>
        <?php endif; ?>
        <a href="#">Cart 🛒</a>
    </div>
</header>
<!--Footer-->

<main class="main">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>

<footer class="site-footer" role="contentinfo">
    <div class="site-footer-inner">
        <!-- Left: copyright -->
        <div class="footer-left">
            <nav class="footer-nav">
                <li class="h6">
                    <a href="<?= $this->Url->build(['controller' => 'ContactUs', 'action' => 'add']) ?>">Contact</a>
                </li>
                <li class="h6">
                    <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'index']) ?>">Products</a>
                </li>
                <li class="h6">
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'about']) ?>">About us</a>
                </li>
            </nav>
            <div class="copyright">
                © Iconic Prints
            </div>
        </div>

        <!-- Center: social icons -->
        <nav class="social" aria-label="Social media">
            <a class="instagram" href="https://www.instagram.com/your_handle" target="_blank" rel="noopener" aria-label="Instagram">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a class="twitter" href="https://x.com/your_handle" target="_blank" rel="noopener" aria-label="X">
                <i class="fa-brands fa-x-twitter"></i>
            </a>
            <a class="facebook" href="https://www.facebook.com/your_page" target="_blank" rel="noopener" aria-label="Facebook">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a class="tiktok" href="https://www.tiktok.com/@your_handle" target="_blank" rel="noopener" aria-label="TikTok">
                <i class="fa-brands fa-tiktok"></i>
            </a>
        </nav>

        <!-- Right: contact block-->
        <address class="contact-block">
            <div class="contact-city">Melbourne</div>
            <div>Wellington Road, Clayton<br>Victoria, 3800</div>
            <div><a href="">+61 111 222 333</a></div>
            <div><a href="">iconicprintsoffical@gmail.com</a></div>
        </address>
    </div>
</footer>



</body>
</html>
