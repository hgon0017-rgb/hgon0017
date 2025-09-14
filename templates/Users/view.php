<?php
/**
 * User detail page
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="content-card">
    <!-- Header with actions -->
    <div style="display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:15px;">
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

    <!-- Details Table -->
    <div class="table-responsive">
        <table>
            <tbody>
            <tr><th style="width:200px;">ID</th><td><?= $this->Number->format($user->id) ?></td></tr>
            <tr><th>Email</th><td><?= h($user->email) ?></td></tr>
            <tr><th>Role</th><td><?= h($user->role ?? 'customer') ?></td></tr>
            <tr><th>Nonce</th><td><?= h($user->nonce) ?></td></tr>
            <tr><th>Nonce Expiry</th><td><?= h($user->nonce_expiry) ?></td></tr>
            <tr><th>Created</th><td><?= $user->created ? $user->created->format('Y-m-d H:i') : '—' ?></td></tr>
            <tr><th>Modified</th><td><?= $user->modified ? $user->modified->format('Y-m-d H:i') : '—' ?></td></tr>
            </tbody>
        </table>
    </div>
</div>
