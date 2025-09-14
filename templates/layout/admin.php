<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($this->fetch('title')) ?> | Admin</title>
    <?= $this->Html->css(['default']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <style>
        body {
            margin: 0;
            font-family: system-ui, sans-serif;
            background: #f3f4f6;
        }

        .admin-shell {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 20px;
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Sidebar */
        .sidebar {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
        }

        .sidebar h4 {
            margin: 6px 0 14px;
            font-size: 18px;
            font-weight: 600;
        }

        .nav-list { list-style: none; padding: 0; margin: 0; }
        .nav-list li { margin: 6px 0; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            text-decoration: none;
            color: #111827;
            background: #fff;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            background: #f3f4f6;
        }

        .nav-link.active {
            background: #e9efff;
            border-color: #c7d2fe;
            font-weight: 700;
        }

        /* Content area */
        main {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            overflow-x: auto; /* prevent table overflow */
        }

        /* Reusable card for content */
        .content-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px;
        }

        @media (max-width: 900px) {
            .admin-shell { grid-template-columns: 1fr; }
            .sidebar { margin-bottom: 20px; }
        }
    </style>
</head>
<body>
<div class="admin-shell">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h4>Admin</h4>
        <ul class="nav-list">
            <li><?= $this->Html->link('🛒 Products', ['controller'=>'Products','action'=>'dashboard'], [
                    'class'=>'nav-link' . ($this->fetch('active')==='products'?' active':'')
                ]) ?></li>
            <li><?= $this->Html->link('👥 Users', ['controller'=>'Users','action'=>'index'], [
                    'class'=>'nav-link' . ($this->fetch('active')==='users'?' active':'')
                ]) ?></li>
            <li><?= $this->Html->link('📩 Enquiries', ['controller'=>'ContactUs','action'=>'index'], [
                    'class'=>'nav-link' . ($this->fetch('active')==='enquiries'?' active':'')
                ]) ?></li>
        </ul>
    </aside>

    <!-- Content -->
    <main>
        <?= $this->fetch('content') ?>
    </main>

</div>
</body>
</html>
