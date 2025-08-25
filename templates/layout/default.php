<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
$cakeDescription = 'CakePHP: the rapid development php framework';
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
        <?= $this->Html->link('Dashboard', '/', []) ?>
        <a href="#">Products</a>
        <a href="#">Notification</a>
        <a href="#">About Us</a>
        <a href="#">Help</a>
    </div>

    <div class="nav-right">
        <?php if ($this->Identity->isLoggedIn()): ?>
        <a href="<?=$this->Url->build(['controller' => 'ContactUs', 'action' => 'index'])?>">Admin</a>
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

<main class="main">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>

</body>
</html>
