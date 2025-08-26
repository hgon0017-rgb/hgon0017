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

<!-- Keep hero banner edge-to-edge -->

<style>
    /* Banner full-bleed, keep layout padding off on this page */
    .main { padding: 0; }
    .hero-img { display:block; width:100%; height:auto; }

    /* Products row: match side padding with How it Works, trim card width */
    body .grid{
        display: grid;
        grid-template-columns: repeat(3, minmax(300px, 1fr)); /* slightly wider cards */
        gap: 1.5rem;
        padding-inline: 2rem;  /* matches How it Works */
        width: 100%;           /* no max-width cap */
    }
    @media (max-width: 1100px){
        body .grid{ grid-template-columns: repeat(2, minmax(300px,1fr)); }
    }
    @media (max-width: 700px){
        body .grid{ grid-template-columns: 1fr; }
    }

    /* How it Works: two columns with gap; right card compact */
    .howitworks {
        display: flex;
        gap: 1.5rem;
        padding-inline: 2rem;               /* aligns with products row */
    }
    .howitworks .card-lg { flex: 1; }     /* left card grows */
    .howitworks .card-lg:last-child{
        flex: 0 0 auto;
        max-width: 350px;                   /* control width, no edge overflow */
    }
    @media (max-width: 992px){
        .howitworks{ flex-direction: column; }
        .howitworks .card-lg:last-child{ max-width: 100%; }
    }

</style>

<!-- HERO -->
<div class="hero">
    <?= $this->Html->image('printing-banner-3.jpg', [
        'class' => 'hero-img',
        'alt'   => 'Printing Banner'
    ]) ?>

    <div class="hero-content">
        <h1 class="hero-title">Iconic Prints</h1>
    </div>
</div>


<main class="main">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>

<div class="toolbar"
     style="padding-inline:2rem;
            margin-top: clamp(12px, 2.5vw, 36px);
            margin-bottom: clamp(8px, 1.25vw, 16px);">
    <h2 style="margin: 0 0 6px 0;">Products</h2>
    <span style="background:#eee; border-radius:999px; padding:6px 10px; font-size:13px; display:inline-block;">
        Flags ▾
    </span>
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

<h2 style="padding-inline:2rem;">How it Works</h2>
<div class="howitworks" style="margin-bottom: clamp(40px, 8vw, 120px);">

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
        <a class="btn" href="<?= $this->Url->build(['controller' => 'ContactUs', 'action' => 'add']) ?>">
            Contact Us ➜
        </a>
    </div>
</div>
