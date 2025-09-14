<?php
/**
 * User detail page (Admin style)
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$productsUrl = $this->Url->build(['controller' => 'Products', 'action' => 'dashboard']);
$usersUrl    = $this->Url->build(['controller' => 'Users',    'action' => 'index']);
$contactsUrl = $this->Url->build(['controller' => 'ContactUs','action' => 'index']);
?>

<style>
    .admin-shell { display:grid; grid-template-columns:220px 1fr; gap:20px; max-width:1400px; margin:0 auto; padding:20px; }
    .sidebar { background:#f8fafc; border:1px solid #e5e7eb; border-radius:12px; padding:14px; }
    .sidebar h4 { margin:6px 10px 12px; font-size:18px; }
    .nav-list{ list-style:none; padding:0; margin:0; }
    .nav-list li{ margin:4px 0; }
    .nav-link{ display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; text-decoration:none;
        color:#111827; background:#fff; border:1px solid #e5e7eb; }
    .nav-link.active{ background:#e9efff; border-color:#c7d2fe; font-weight:700; }

    .content-card{ background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:18px; }
    .btn { display:inline-block; padding:8px 12px; border-radius:6px; font-size:13px; text-decoration:none; margin-left:6px; }
    .btn-dark { background:#333; color:#fff; }
    .btn-grey { background:#555; color:#fff; }
    .btn-danger { background:#c00; color:#fff; }

    table { width:100%; border-collapse:collapse; font-size:13px; margin-top:15px; }
    th, td { border:1px solid #ccc; padding:8px; vertical-align:top; }
    thead { background:#f2f2f2; }
    .muted{color:#6b7280}
</style>

<div class="admin-shell">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h4>Admin</h4>
        <ul class="nav-list">
            <li><a class="nav-link" href="<?= $productsUrl ?>">🛒 Products</a></li>
            <li><a class="nav-link active" href="<?= $usersUrl ?>">👥 Users</a></li>
            <li><a class="nav-link" href="<?= $contactsUrl ?>">📩 Enquiries</a></li>
        </ul>
    </aside>

    <!-- Main -->
    <main>
        <div class="content-card">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:10px;">
                <h3 style="margin:0">User: <?= h($user->email) ?></h3>
                <div>
                    <?= $this->Html->link('Edit ✎', ['action' => 'edit', $user->id], ['class'=>'btn btn-dark']) ?>
                    <?= $this->Form->postLink(
                        'Delete ✖',
                        ['action' => 'delete', $user->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class'=>'btn btn-danger']
                    ) ?>
                    <?= $this->Html->link('← Back to Users', ['action' => 'index'], ['class'=>'btn btn-grey']) ?>
                </div>
            </div>

            <table>
                <tbody>
                <tr>
                    <th>ID</th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td><?= h($user->role ?? 'customer') ?></td>
                </tr>
                <tr>
                    <th>Nonce</th>
                    <td><?= h($user->nonce) ?></td>
                </tr>
                <tr>
                    <th>Nonce Expiry</th>
                    <td><?= h($user->nonce_expiry) ?></td>
                </tr>
                <tr>
                    <th>Created</th>
                    <td><?= $user->created ? $user->created->format('Y-m-d H:i') : '—' ?></td>
                </tr>
                <tr>
                    <th>Modified</th>
                    <td><?= $user->modified ? $user->modified->format('Y-m-d H:i') : '—' ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </main>

</div>
