<?php /* templates/layout/login.php */ ?>
<?php
/* templates/layout/login.php */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?: 'Login - Iconic Prints' ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            /* full background image */
            background: url("<?= $this->Url->image('pexels-christopher-gawel-23527-955617.jpg') ?>")
            no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<?= $this->fetch('content') ?>

<?= $this->fetch('script') ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


