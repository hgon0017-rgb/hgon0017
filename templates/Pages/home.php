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


?>
<main class="main">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
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
