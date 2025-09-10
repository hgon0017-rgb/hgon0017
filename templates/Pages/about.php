<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About Us</title>
    <style>
        body { margin: 0; }

        /* Top hero section  */
        .section--hero {
            width: 100%;
            height: 48vh;
            min-height: 320px;
            max-height: 560px;
            position: relative;
            overflow: hidden;
            margin-bottom: 32px;
        }
        .hero__img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }
        .about__content {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: flex-start;
            padding: 24px 28px;
            color: #fff;
            background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,.45) 100%);
        }

        /* About sections */
        .about-design {
            padding: 56px 20px;
            background: #fff;
        }
        .about-design__wrap {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 36px;
            align-items: start;
        }
        .about-design__title {
            font-size: 1.6rem;
            line-height: 1.35;
            font-weight: 800;
            text-transform: uppercase;
            margin: 0 0 18px;
            letter-spacing: .4px;
        }
        .about-design__body {
            color: #2a2a2a;
            line-height: 1.85;
            font-size: 1rem;
            font-style: italic;
        }
        .about-design__body p { margin: 0 0 14px; }
        .about-design__media img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Bottom centered quote */
        .about-quote {
            max-width: 900px;
            margin: 48px auto 64px;
            padding: 0 20px;
            text-align: center;
            font-size: 1.3rem;
            line-height: 1.9;
            font-style: italic;
            color: #222;
        }

        /* Responsive */
        @media (max-width: 900px){
            .about-design__wrap{
                grid-template-columns: 1fr;
            }
            .about-design__media{ order: 2; }
            .about-design__text{ order: 1; }
        }
    </style>
</head>
<body>
<main>

    <!-- Hero Section -->
    <section class="section--hero">
        <?= $this->Html->image('pexels-annushka-ahuja-8114503.jpg', [
            'alt' => 'Photographer in darkroom',
            'class' => 'hero__img'
        ]) ?>
        <div class="about__content">
        </div>
    </section>

    <!-- About Section #1 -->
    <section class="about-design">
        <div class="about-design__wrap">
            <div class="about-design__text">
                <h2 class="about-design__title">Crafting Prints with Passion</h2>
                <div class="about-design__body">
                    <p>“Every print tells a story of dedication and artistry. With a blend of modern techniques and timeless craftsmanship, we bring images to life in their purest form. From the moment ink touches paper, a dialogue begins—between creativity and precision, between vision and reality. Each detail is carefully considered, each shade intentionally chosen, so that the final print carries not just an image, but an emotion.”</p>
                    <p>“Behind every piece lies a process driven by passion. From the first sketch to the final press, we ensure that every line, shade, and contour contributes to a coherent story. The choice of material, the balance of tones, and the subtleties of detail all come together to create an experience that speaks to both the eye and the heart.”</p>
                </div>
            </div>
            <div class="about-design__media">
                <?= $this->Html->image('pexels-fotios-photos-11073660.jpg', [
                    'alt' => 'Cyanotype floral print'
                ]) ?>
            </div>
        </div>
    </section>

    <!-- About Section #2 -->
    <section class="about-design">
        <div class="about-design__wrap">
            <div class="about-design__media">
                <?= $this->Html->image('aboutimage.jpg', [
                    'alt' => 'woman holding iamge'
                ]) ?>
            </div>
            <div class="about-design__text">
                <h2 class="about-design__title">What we do</h2>
                <div class="about-design__body">
                    <p>“From concept to creation, our team transforms ideas into enduring works of print. We focus on detail, quality, and innovation to deliver results that inspire and captivate. Our methods unite the sensitivity of traditional artistry with the precision of modern technology, allowing each project to stand as both a piece of beauty and a statement of identity.”</p>
                    <p>“What we do is more than just printing—it is about translating vision into reality. Every collaboration is approached as a unique journey, where your ideas shape the direction, and our expertise ensures the outcome. By weaving creativity with discipline, and imagination with craft, we turn inspiration into timeless works that resonate long after the ink has dried.”</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom centered quote -->
    <section class="about-quote">
        “Only the highest quality of prints. Produced in Australia, delivered to your doorstep.”
    </section>

</main>
</body>
</html>




