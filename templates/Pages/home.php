<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;


$this->disableAutoLayout();
$this->assign('title', 'Dashboard');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($this->fetch('title')) ?></title>
    <style>
        :root {
            --bg: #f6f7fb;
            --card: #ffffff;
            --muted: #767676;
            --text: #222;
            --ring: #e9e9ee;
            --accent: #f37021;
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
    </style>
</head>
<body>

<header class="navbar">
    <div class="nav-left">
        <a href="#">Dashboard</a>
        <a href="#">Products</a>
<!--        <a href="#">Testimonials</a>-->
<!--        <a href="--><?php //= $this->Url->build(['controller' => 'ContactUs', 'action' => 'add']) ?><!--">Contact Us</a>-->
        <a href="#">Notification</a>
        <a href="#">About Us</a>
        <a href="#">Help</a>
    </div>
    <div class="nav-right">
        <!--  Login/Register -->
        <a class="btn" href="<?= $this->Url->build(['controller' => 'Auth', 'action' => 'login']) ?>">
            Login or Register ➜
        </a>
        <a href="#">Cart 🛒</a>
    </div>
</header>

<!-- Main  -->
<main class="main">
    <div class="toolbar">
        <h2 style="margin:0;">Products</h2>
        <span style="background:#eee; border-radius:999px; padding:6px 10px; font-size:13px;">Flags ▾</span>
    </div>

    <section class="grid">
        <article class="card">
            <div class="thumb"></div>
            <h3>National Flags</h3>
            <p>Proudly display your heritage with our high-quality national flags.</p>
        </article>
        <article class="card">
            <div class="thumb"></div>
            <h3>Corporate Flags</h3>
            <p>Elevate your brand presence with custom corporate flags.</p>
        </article>
        <article class="card">
            <div class="thumb"></div>
            <h3>Custom Flag</h3>
            <p>Bring any design to life with fully customized flag printing.</p>
        </article>
    </section>

    <h2>How it Works</h2>
    <div class="row">
        <div class="card-lg">
            <span class="tag">Guide</span>
            <ul class="bullets">
                <li>Choose Your <strong>Product</strong></li>
                <li>Send Your Design or Request <strong>Customisation</strong></li>
                <li>We Print & Deliver</li>
                <li>You Display with <strong>Pride!</strong></li>
            </ul>
        </div>
        <div class="card-lg">
            <span class="tag">Need Help</span>
            <h3>Contact & Enquiry Section</h3>
            <p class="muted">Whether it’s specs, pricing, or lead time, we’re here to help.</p>
            <a class="btn" href="<?= $this->Url->build(['controller' => 'ContactUs', 'action' => 'add']) ?>">Contact Us ➜</a>
        </div>
    </div>
</main>

</body>
</html>
