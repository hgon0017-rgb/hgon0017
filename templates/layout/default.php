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

    <?= $this->fetch('meta') . $this->fetch('css') . $this->fetch('script') ?>
    <style>

        :root {
            --bg: #f6f7fb;
            --card: #ffffff;
            --muted: #767676;
            --text: #222;
            --ring: #e9e9ee;
            --accent: #000000;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .navbar {
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 24px;
        }

        .nav-left, .nav-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .nav-left a, .nav-right a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
        }

        .nav-left a:hover, .nav-right a:hover {
            text-decoration: underline;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #020202;
            background: transparent;
            border-radius: 999px;
            padding: 8px 12px;
            text-decoration: none;
            color: #000000;
            font-size: 14px;
            font-weight: 500;
            transition: 0.2s ease;
        }

        .btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* main */
        .main {
            padding: 28px 26px;
        }

        h2 {
            margin: 18px 0 12px;
            font-size: 22px
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--ring);
            border-radius: 16px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .thumb {
            height: 120px;
            border-radius: 12px;
            background: #e8e8ee;
        }

        .card h3 {
            margin: 0;
            font-size: 16px;
        }

        .card p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 16px;
            margin-top: 16px;
        }

        .card-lg {
            background: var(--card);
            border: 1px solid var(--ring);
            border-radius: 16px;
            padding: 16px;
        }

        .bullets {
            margin: 6px 0 0 0;
            padding-left: 18px;
        }

        .bullets li {
            margin: 6px 0;
        }

        .tag {
            display: inline-block;
            background: #fff;
            border: 1px solid var(--ring);
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 12px;
            margin-bottom: 10px;
        }
        /* ===== Footer: left copyright / center social / right spacer ===== */
        .site-footer {
            background: #fff;
            color: #555;
            border-top: 1px solid #e7e7e7;
            padding: 14px 0;
            font-size: 14px;
        }
        .site-footer-inner {
            display: grid;                      /* 3 columns: 1fr | auto | 1fr  */
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .site-footer .copyright { justify-self: start; }
        .site-footer .spacer    { justify-self: end; }   /* empty, keeps center truly centered */

        /* override global <a> styles inside footer */
        .site-footer a { text-decoration: none; }

        /* social icons (center) */
        .site-footer .social {
            display: flex; gap: 12px; justify-content: center;
        }
        .site-footer .social a {
            width: 36px; height: 36px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            background: #f3f4f6; color: #555; font-size: 18px;
            transition: transform .2s, background .2s, color .2s;
        }
        .site-footer .social a:hover {
            transform: translateY(-2px) scale(1.15);
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }



        /* --- Specific colors per platform --- */
        .site-footer .social a.instagram { background: #E4405F; color: #fff; }
        .site-footer .social a.twitter   { background: #000000; color: #fff; }
        .site-footer .social a.facebook  { background: #1877F2; color: #fff; }
        .site-footer .social a.tiktok    { background: #ff0050; color: #fff; }

        .site-footer .social a:hover {
            transform: scale(1.15);
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .site-footer {
            background: #000;   /* Avex style black background */
            color: #fff;
            padding: 40px 24px;
            font-size: 14px;
        }

        .site-footer-inner {
            display: grid;
            grid-template-columns: 1fr auto 1fr; /* left | center | right */
            max-width: 1200px;
            margin: 0 auto;
            gap: 20px;
        }

        /* Left column */
        .footer-left {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .footer-nav {
            display: flex;
            gap: 24px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
        }

        .footer-nav a {
            color: #fff;
            text-decoration: none;
        }

        .footer-nav a:hover {
            text-decoration: underline;
        }

        .copyright {
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }

        /* Social icons (center) */
        .social {
            display: flex;
            gap: 12px;
            justify-content: center;
            align-items: center;
        }

        /* Right contact block */
        .contact-block {
            text-align: right;
            font-style: normal;
            font-size: 13px;
            line-height: 1.6;
            color: #aaa;
        }

        .contact-block .contact-city {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            color: #fff;
            margin-bottom: 6px;
        }

        .contact-block a {
            color: #aaa;
            text-decoration: none;
        }

        .contact-block a:hover {
            color: #fff;
        }
    </style>
</head>
<body>

<header class="navbar">
    <div class="nav-left">
        <?= $this->Html->link('Dashboard', '/', []) ?>
        <a href="#">Products</a>
        <a href="#">Notification</a>
        <a href="#">About Us</a>
        <a href="#">Help</a>
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
                    <a href="#">Contact</a>
                </li>
                <li class="h6">
                    <a href="#">Products</a>
                </li>
                <li class="h6">
                    <a href="#">About us</a>
                </li>
            </nav>
            <div class="copyright">
                © Iconic Prints
            </div>
        </div>

        <!-- Center: social icons (uses your .social) -->
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

        <!-- Right: contact block (replaces the old 'spacer') -->
        <address class="contact-block">
            <div class="contact-city">Melbourne</div>
            <div>Wellington Road, Clayton<br>Victoria, 3800</div>
            <div><a href="tel:+61111222333">+61 111 222 333</a></div>
            <div><a href="mailto:newbusiness@iconicprints.com">newbusiness@iconicprints.com</a></div>
        </address>
    </div>
</footer>



</body>
</html>
