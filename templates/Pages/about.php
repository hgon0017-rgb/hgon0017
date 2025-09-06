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
    <?= $this->Html->css('about') ?>
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
            <p>Only the highest quality of prints. Produced in Australia, delivered to your doorstep.</p>
        </div>
    </section>

    <!-- Story Section -->
    <section class="about-design">
        <div class="about-design__wrap">
            <div class="about-design__text">
                <h2 class="about-design__title">
                    Crafting Prints with Passion
                </h2>
                <div class="about-design-text">
                    <p>
                        Add text here, make up a random story
                    </p>
                    <p>
                        Same with here
                    </p>
                </div>
            </div>
            <div class="about-design__media">
                <?= $this->Html->image('pexels-fotios-photos-11073660.jpg', [
                    'alt' => 'Scenic mountain view'
                ]) ?>
            </div>
        </div>
    </section>

    <section class="about-design">
        <div class="about-design__wrap">
            <div class="about-design__media">
                <?= $this->Html->image('pexels-fotios-photos-11073660.jpg', [
                    'alt' => 'Scenic mountain view'
                ]) ?>
            </div>
            <div class="about-design__text">
                <h2 class="about-design__title">
                    What we do
                </h2>
                <div class="about-design-text">
                    <p>
                        Add text here, make up a random story
                    </p>
                    <p>
                        Same with here
                    </p>
                </div>
            </div>
        </div>
    </section>

</main>
</body>
</html>
