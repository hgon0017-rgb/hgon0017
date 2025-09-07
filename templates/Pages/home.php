<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;
?>

<style>

    /* Background colour to match logo */
    body {
        background-color: #f9f6f1; /* warm off-white */
    }

    /* Smooth anchor scroll */
    html { scroll-behavior: smooth; }

    /* Banner */
    .main { padding: 0; }
    .hero-img { display:block; width:100%; height:auto; }

    /* Products Grid */
    body .grid{
        display: grid;
        grid-template-columns: repeat(3, minmax(300px, 1fr));
        gap: 1.5rem;
        padding-inline: 2rem;
        width: 100%;
    }
    @media (max-width: 1100px){
        body .grid{ grid-template-columns: repeat(2, minmax(300px,1fr)); }
    }
    @media (max-width: 700px){
        body .grid{ grid-template-columns: 1fr; }
    }

    /* ===== How it Works Section  ===== */
    .howitworks {
        display: flex; /*  horizontal layout */
        gap: 1.5rem; /*  spacing */
        padding: 2rem; /*  padding */
    }

    /* Card  */
    .howitworks .card-lg {
        background: #fff; /*  white background */
        border-radius: 12px; /*  rounded corners */
        padding: 20px; /*  padding */
        box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* shadow */
        flex: 1; /*  equal width */
    }

    /* Right-side Card  */
    .howitworks .card-lg:last-child {
        flex: 0 0 auto;
        max-width: 350px; /*  max width */
    }

    /* Responsive  */
    @media (max-width: 992px){
        .howitworks { flex-direction: column; } /*  vertical stack */
        .howitworks .card-lg:last-child { max-width: 100%; }
    }

    /* Numbered List with Circles  */
    .howitworks ul {
        list-style: none; /* remove default dots  */
        counter-reset: step; /* reset counter  */
        padding-left: 0;
    }

    .howitworks ul li {
        margin-bottom: 16px; /* spacing  */
        font-size: 16px; /* font size  */
        line-height: 1.6; /* line height  */
        position: relative;
        padding-left: 42px; /* leave space for number  */
    }

    .howitworks ul li::before {
        counter-increment: step; /* increase counter+1 */
        content: counter(step); /* show number  */
        position: absolute;
        left: 0;
        top: 0;
        width: 28px; /* circle size  */
        height: 28px;
        border-radius: 50%; /* make it round  */
        background: #292929; /* blue circle  */
        color: #fff; /* white text  */
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
    }



    /* Hero Overlay */
    .hero{ position: relative; overflow: hidden; }
    .hero::after{
        content:"";
        position:absolute;
        inset:0;
        background: linear-gradient(to bottom, rgba(0,0,0,.1), rgba(0,0,0,.25));
        pointer-events:none;
    }
    .hero-content{
        position:absolute; inset:0;
        display:flex; align-items:center; justify-content:center;
        padding: clamp(12px, 3vw, 32px);
    }
    .hero-inner{
        width: min(100%, 880px);
        text-align: center;
        margin: 0 auto;
    }
    .hero-title {
        color: #fff;
        font-weight: 800;
        line-height: 1.08;
        font-size: clamp(40px, 6vw, 72px);
        /* multiple shadows to make text stand out */
        text-shadow:
            2px 2px 4px rgba(0,0,0,0.6),   /* close shadow */
            4px 4px 10px rgba(0,0,0,0.5),  /* mid shadow */
            0 0 12px rgba(0,0,0,0.4);      /* soft outer glow */
        letter-spacing: 1px;
    }

    /* Hero Title  */
    .hero-title a {
        color: #fff; /*  default white text */
        text-decoration: none; /*  remove underline */
        transition: all 0.3s ease; /*  smooth animation */
    }

    .hero-title a:hover {
        color: #ffeb3b; /*  bright yellow on hover */
        text-shadow:
            0 0 6px rgba(255, 235, 59, 0.7),  /*  soft glow */
            0 0 12px rgba(255, 235, 59, 0.6);
        transform: scale(1.05); /*  slightly bigger */
    }

    .hero-title a:focus-visible { outline: 2px solid #fff; outline-offset: 4px; }

    .hero-sub{
        color:#f9f9f9;
        margin-top: 12px;
        font-size: clamp(18px, 2.5vw, 22px);
        text-shadow: 0 2px 6px rgba(0,0,0,0.5);
    }

    /* ===== Products Section ===== */
    .grid {
        display: grid; /*  grid layout */
        grid-template-columns: repeat(3, minmax(280px, 1fr)); /*  three columns */
        gap: 1.5rem; /*  spacing */
        padding: 2rem; /*  padding */
    }

    /* Responsive  */
    @media (max-width: 1100px){
        .grid{ grid-template-columns: repeat(2, minmax(280px,1fr)); } /*  two columns on tablet */
    }
    @media (max-width: 700px){
        .grid{ grid-template-columns: 1fr; } /*  single column on mobile */
    }

    /* Product Card  */
    .card {
        background: #fff; /*  white background */
        border-radius: 12px; /*  border radius */
        padding: 16px; /*  padding */
        box-shadow: 0 4px 12px rgba(0,0,0,0.08); /*  shadow */
        transition: transform 0.2s ease, box-shadow 0.2s ease; /* 动 animation */
        text-align: center; /*  center text */
    }

    /* Hover Effect  */
    .card:hover {
        transform: translateY(-6px); /*  effect of lifting */
        box-shadow: 0 8px 20px rgba(0,0,0,0.16); /*  stronger shadow */
    }

    /* Product Image  */
    .card img {
        width: 100%;
        height: 180px;
        object-fit: cover; /*  fill & crop */
        border-radius: 8px; /*  rounded corners */
        margin-bottom: 12px; /*  spacing below */
    }

    /* Product Title  */
    .card h3 {
        margin: 8px 0;
        font-size: 20px; /*  font size */
        font-weight: 600; /*  bold */
        color: #222;
    }

    /* Product Description  */
    .card p {
        font-size: 15px; /*  font size */
        color: #555; /*  dark gray */
        line-height: 1.4; /*  line height */
    }
    /* Contact Us Button  */
    .btn {
        display: inline-block; /* inline-block  */
        background: #007bff;   /* blue background  */
        color: #fff;           /* white text  */
        padding: 12px 24px;    /* padding  */
        border-radius: 8px;    /* rounded corners  */
        text-decoration: none; /* remove underline 去 */
        font-weight: 600;      /* bold  */
        font-size: 16px;       /* font size  */
        transition: background 0.2s, transform 0.2s; /* hover animation  */
    }

    /* Hover Effect  */
    .btn:hover {
        background: #0056b3; /* darker blue  */
        transform: translateY(-2px); /* slight lift  */
    }


    /* --- HERO SLIDESHOW (fixed height + cross-fade) --- */
    .hero{
        position: relative;
        min-height: clamp(400px, 70vh, 820px);  /* ensures the hero is visible */
        overflow: hidden;
    }

    /* slides occupy the whole hero */
    .hero .slides{ position:absolute; inset:0; }

    /* individual slides */
    .hero .slide{
        position:absolute; inset:0;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transition: opacity 900ms ease-in-out;
    }
    .hero .slide.is-active{ opacity: 1; }


    .hero-content{
        position:absolute; inset:0;
        display:flex; align-items:center; justify-content:center;
        z-index: 2;
        padding: clamp(12px, 3vw, 32px);
    }


    .hero::after{
        content:"";
        position:absolute; inset:0;
        background: linear-gradient(to bottom, rgba(0,0,0,.1), rgba(0,0,0,.25));
        pointer-events:none;
        z-index:1;                             /* sits above images, below text */
    }

</style>

<!-- HERO -->
<div class="hero" role="banner" aria-label="Iconic Prints hero">
    <div class="slides" aria-hidden="true">
        <div class="slide is-active" style="background-image:url('<?= $this->Url->image("printing-banner-3.jpg") ?>');"></div>
        <div class="slide" style="background-image:url('<?= $this->Url->image("banner-1.jpg") ?>');"></div>
        <div class="slide" style="background-image:url('<?= $this->Url->image("banner-2.jpg") ?>');"></div>
        <div class="slide" style="background-image:url('<?= $this->Url->image("banner-3.jpg") ?>');"></div>
        <div class="slide" style="background-image:url('<?= $this->Url->image("banner-4.jpg") ?>');"></div>
    </div>

    <div class="hero-content">
        <div class="hero-inner" style="text-align:center; max-width:880px; margin:0 auto;">
            <h1 class="hero-title"><a href="#products" title="Jump to products">Iconic Prints</a></h1>
            <p class="hero-sub">Flags, banners & signage</p>
        </div>
    </div>
</div>


<section class="container py-4" aria-label="Product lines overview" style="max-width:980px;">
    <p class="lead" style="margin:0;">
        We offer three main product lines:
        <strong>Flags</strong> for events and storefronts,
        durable <strong>Signage</strong> for indoor and outdoor use,
        and flexible <strong>Custom Orders</strong> for unique sizes, materials and finishes.
        Quick quotes and reliable turnaround.
    </p>
</section>

<main class="main" role="main">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>

<!-- Products -->
<div class="toolbar" style="padding-inline:2rem; margin-top:12px; margin-bottom:16px;">
    <h2 id="products" style="margin: 0 0 6px 0;">Products</h2>
    <span style="background:#eee; border-radius:999px; padding:6px 10px; font-size:13px; display:inline-block;">
        Flags ▾
    </span>
</div>

<section class="grid" aria-label="Flag products">
    <article class="card">
        <?= $this->Html->image('flags-national.jpg', [
            'alt' => 'Assorted national flags arranged together'
        ]) ?>
        <h3>National Flags</h3>
        <p>Proudly display your heritage with our high-quality national flags.</p>
    </article>

    <article class="card">
        <?= $this->Html->image('flags-corporate.jpg', [
            'alt' => 'Corporate flags flying outside a modern building'
        ]) ?>
        <h3>Corporate Flags</h3>
        <p>Elevate your brand presence with custom corporate flags.</p>
    </article>

    <article class="card">
        <?= $this->Html->image('flags-custom.jpg', [
            'alt' => 'Blank feather and teardrop flag shapes for custom printing'
        ]) ?>
        <h3>Custom Flag</h3>
        <p>Bring any design to life with fully customized flag printing.</p>
    </article>
</section>

<!-- How it Works -->
<h2 style="padding-inline:2rem; margin-top:40px;">How it Works</h2>
<div class="howitworks" style="margin-bottom:60px;">
    <div class="card-lg">
        <span class="tag">Guide</span>
        <ul class="bullets">
            <li>Choose Your <strong>Product</strong></li>
            <li>Send Your Design or Request <strong>Customisation</strong></li>
            <li>We Print &amp; Deliver</li>
            <li>You Display with <strong>Pride!</strong></li>
        </ul>
    </div>
    <div class="card-lg">
        <span class="tag">Need Help</span>
        <h3>Contact &amp; Enquiry Section</h3>
        <p class="muted">Whether it’s specs, pricing, or lead time, we’re here to help.</p>
        <a class="btn" href="<?= $this->Url->build(['controller' => 'ContactUs', 'action' => 'add']) ?>">
            Contact Us ➜
        </a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const slides = Array.from(document.querySelectorAll(".hero .slide"));
        if (slides.length < 2) return;

        let i = 0;
        const INTERVAL = 4000; // 8s; changes timing of the slideshow

        setInterval(() => {
            slides[i].classList.remove("is-active");
            i = (i + 1) % slides.length;
            slides[i].classList.add("is-active");
        }, INTERVAL);

        // keep your Products link jump
        document.querySelectorAll('.nav-left a, .nav-right a').forEach(link => {
            if (link.textContent.trim() === 'Products') link.setAttribute('href', '#products');
        });
    });
</script>
