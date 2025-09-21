<?php
/**
 * Home page
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
    .dropdown {
        display: inline-block;
        position: relative;
    }

    .dropdown-btn {
        background: #eee;
        border: none;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 13px;
        cursor: pointer;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-top: 4px;
        min-width: 140px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        list-style: none;
        padding: 6px 0;
        z-index: 1000;
    }

    .dropdown-menu li a {
        display: block;
        padding: 8px 12px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
    }

    .dropdown-menu li a:hover {
        background: #f2f2f2;
    }

    /* Active dropdown */
    .dropdown-menu.show {
        display: block;
    }

    /* Background to match logo */
    body { background-color: #f9f6f1; }

    /* Smooth anchor scroll (kept for other anchors) */
    html { scroll-behavior: smooth; }

    /* Banner */
    .main { padding: 0; }
    .hero-img { display:block; width:100%; height:auto; }

    /* Generic grid (unused for nav now but kept) */
    body .grid{
        display: grid;
        grid-template-columns: repeat(3, minmax(300px, 1fr));
        gap: 1.5rem;
        padding-inline: 2rem;
        width: 100%;
    }
    @media (max-width: 1100px){ body .grid{ grid-template-columns: repeat(2, minmax(300px,1fr)); } }
    @media (max-width: 700px){ body .grid{ grid-template-columns: 1fr; } }

    /* How it Works */
    .howitworks { display:flex; gap:1.5rem; padding:2rem; }
    .howitworks .card-lg {
        background:#fff; border-radius:12px; padding:20px;
        box-shadow:0 4px 12px rgba(0,0,0,0.1); flex:1;
    }
    .howitworks .card-lg:last-child { flex:0 0 auto; max-width:350px; }
    @media (max-width: 992px){
        .howitworks { flex-direction:column; }
        .howitworks .card-lg:last-child { max-width:100%; }
    }
    .howitworks ul { list-style:none; counter-reset:step; padding-left:0; }
    .howitworks ul li{
        margin-bottom:16px; font-size:16px; line-height:1.6; position:relative; padding-left:42px;
    }
    .howitworks ul li::before{
        counter-increment:step; content:counter(step); position:absolute; left:0; top:0;
        width:28px; height:28px; border-radius:50%; background:#292929; color:#fff;
        display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:14px;
    }

    /* HERO slideshow */
    .hero{ position:relative; min-height:clamp(400px, 70vh, 820px); overflow:hidden; }
    .hero .slides{ position:absolute; inset:0; }
    .hero .slide{
        position:absolute; inset:0; background-size:cover; background-position:center;
        opacity:0; transition:opacity 900ms ease-in-out;
    }
    .hero .slide.is-active{ opacity:1; }
    .hero-content{
        position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
        z-index:2; padding:clamp(12px, 3vw, 32px);
    }
    .hero::after{
        content:""; position:absolute; inset:0;
        background:linear-gradient(to bottom, rgba(0,0,0,.1), rgba(0,0,0,.25));
        pointer-events:none; z-index:1;
    }
    .hero-inner{ width:min(100%, 880px); text-align:center; margin:0 auto; }
    .hero-title{ color:#fff; font-weight:800; line-height:1.08; font-size:clamp(40px, 6vw, 72px);
        text-shadow:2px 2px 4px rgba(0,0,0,.6), 4px 4px 10px rgba(0,0,0,.5), 0 0 12px rgba(0,0,0,.4);
        letter-spacing:1px;
    }
    .hero-title a{ color:#fff; text-decoration:none; transition:all .3s ease; }
    .hero-title a:hover{
        color:#ffeb3b; text-shadow:0 0 6px rgba(255,235,59,.7), 0 0 12px rgba(255,235,59,.6);
        transform:scale(1.05);
    }
    .hero-title a:focus-visible{ outline:2px solid #fff; outline-offset:4px; }
    .hero-sub{ color:#f9f9f9; margin-top:12px; font-size:clamp(18px, 2.5vw, 22px); text-shadow:0 2px 6px rgba(0,0,0,.5); }

    /* Section heading */
    h2{ font-size:2rem; font-weight:700; color:#222; margin-bottom:1rem; letter-spacing:.5px; }

    /* Products section (static preview on home) */
    .grid { display:grid; grid-template-columns:repeat(3, minmax(280px, 1fr)); gap:1.5rem; padding:2rem; }
    @media (max-width:1100px){ .grid{ grid-template-columns:repeat(2, minmax(280px,1fr)); } }
    @media (max-width:700px){ .grid{ grid-template-columns:1fr; } }
    .card{
        background:#fff; border-radius:12px; padding:16px; text-align:center;
        box-shadow:0 4px 12px rgba(0,0,0,.08); transition:transform .2s, box-shadow .2s;
    }
    .card:hover{ transform:translateY(-6px); box-shadow:0 8px 20px rgba(0,0,0,.16); }
    .card img{ width:100%; height:180px; object-fit:cover; border-radius:8px; margin-bottom:12px; }
    .card h3{ margin:8px 0; font-size:20px; font-weight:600; color:#222; }
    .card p{ font-size:15px; color:#555; line-height:1.4; }

    /* Button */
    .btn{
        display:inline-block; background:#007bff; color:#fff; padding:12px 24px; border-radius:8px;
        text-decoration:none; font-weight:600; font-size:16px; transition:background .2s, transform .2s;
    }
    .btn:hover{ background:#0056b3; transform:translateY(-2px); }
</style>

<?= $this->Flash->render('modal') ?>

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
        <div class="hero-inner">
            <!-- Link now goes to /products/index -->
            <h1 class="hero-title">
                <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'index']) ?>" title="Shop products">
                    Iconic Prints
                </a>
            </h1>
            <p class="hero-sub">Flags, banners & signage</p>
            <p style="margin-top:14px;">
                <a class="btn" href="<?= $this->Url->build(['controller'=>'Products','action'=>'index']) ?>">Shop Products →</a>
            </p>
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

<!-- Static preview cards on home (kept) -->
<div class="toolbar" style="padding-inline:2rem; margin-top:12px; margin-bottom:16px;">
    <h2 id="products" style="margin:0 0 6px 0;">Products</h2>

    <!-- Dropdown -->
    <div class="dropdown">
        <button class="dropdown-btn" id="dropdownToggle">Flags ▾</button>
        <ul class="dropdown-menu" id="dropdownMenu">
            <li><a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'index']) ?>">Flags</a></li>
            <li><a href="#">Signage</a></li>
            <li><a href="#">Custom order</a></li>
        </ul>
    </div>
</div>

<section class="grid" aria-label="Flag products">
    <article class="card">
        <?= $this->Html->image('flags-national.jpg', ['alt' => 'Assorted national flags arranged together']) ?>
        <h3>National Flags</h3>
        <p>Proudly display your heritage with our high-quality national flags.</p>
    </article>

    <article class="card">
        <?= $this->Html->image('flags-corporate.jpg', ['alt' => 'Corporate flags flying outside a modern building']) ?>
        <h3>Corporate Flags</h3>
        <p>Elevate your brand presence with custom corporate flags.</p>
    </article>

    <article class="card">
        <?= $this->Html->image('flags-custom.jpg', ['alt' => 'Blank feather and teardrop flag shapes for custom printing']) ?>
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
        // Simple slideshow
        const slides = Array.from(document.querySelectorAll(".hero .slide"));
        if (slides.length < 2) return;
        let i = 0;
        const INTERVAL = 4000;
        setInterval(() => {
            slides[i].classList.remove("is-active");
            i = (i + 1) % slides.length;
            slides[i].classList.add("is-active");
        }, INTERVAL);

        // NOTE: removed the code that forced the navbar "Products" link to "#products".
    });
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("dropdownToggle");
        const menu = document.getElementById("dropdownMenu");

        toggle.addEventListener("click", function (e) {
            e.preventDefault();
            menu.classList.toggle("show");
        });

        // Close menu when clicking outside
        document.addEventListener("click", function (e) {
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove("show");
            }
        });
    });
</script>

<?= $this->Flash->render('modal') ?>
