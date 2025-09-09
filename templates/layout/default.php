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
    <style>
        /* === Fix blank space under footer === */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main.main {
            flex: 1 0 auto;
        }

        .site-footer {
            margin-top: auto;
            flex-shrink: 0;
        }

        /* Logo hover effect */
        .logo-link img {
            cursor: pointer;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }
        .logo-link img:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        /* Optional style for cart link */
        .cart-link {
            position: relative;
        }
        .cart-link .badge {
            position: absolute;
            top: -6px;
            right: -10px;
            background: red;
            color: white;
            font-size: 11px;
            padding: 2px 5px;
            border-radius: 50%;
        }
    </style>
</head>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<body>

<header class="navbar">
    <div class="nav-left">
        <?= $this->Html->link(
            $this->Html->image('Iconic-Prints-Logo.png', [
                'alt' => 'Iconic Prints Logo',
                'class' => 'site-logo'
            ]),
            ['controller' => 'Pages', 'action' => 'display', 'home'],
            ['escape' => false, 'class' => 'logo-link']
        ) ?>
    </div>

    <div class="nav-right">
        <?= $this->Html->link('Home', '/', []) ?>
        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'about']) ?>">About</a>
        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'index']) ?>">Products</a>
<!--        <a href="--><?php //= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'help']) ?><!--">Help</a>-->

        <?php if ($this->Identity->isLoggedIn()): ?>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>">Dashboard</a>
            <?= $this->Form->postLink(
                'Logout',
                ['controller'=>'Auth','action'=>'logout','prefix'=>false],
                ['class'=>'btn','form'=>['class'=>'inline']]
            ) ?>
        <?php else: ?>
            <?= $this->Html->link(
                'Login',
                ['controller'=>'Auth','action'=>'login','prefix'=>false],
                ['id' => 'loginBtn']
            ) ?>
            <style>
                #loginBtn {
                    display:inline-block;
                    padding:8px 18px;
                    border:2px solid #fff;
                    border-radius:6px;
                    background:transparent;
                    color:#fff;
                    text-decoration:none;
                    font-weight:600;
                    font-size:14px;
                    transition: all 0.3s ease;
                }
                #loginBtn:hover {
                    background:#fff;
                    color:#000;
                    transform:translateY(-2px);
                    box-shadow:0 4px 8px rgba(0,0,0,0.2);
                }
            </style>
        <?php endif; ?>

        <!-- Cart link -->
        <?= $this->Html->link(
            'Cart 🛒',
            ['controller' => 'Pages', 'action' => 'display', 'cart'],
            ['escape' => false, 'class' => 'cart-link']
        ) ?>
    </div>
</header>

<main class="main">
    <?= $this->Flash->render('modal') ?>   <!-- only our popup -->
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
