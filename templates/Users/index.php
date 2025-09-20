<?php
/**
 * Users index page with sidebar (Income / Product / Users)
 *
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>

<div class="content-card">
    <div style="display:flex; align-items:center; justify-content:space-between;">
        <h3 style="margin:0"><?= __('Users') ?></h3>
        <div>
            <?= $this->Html->link('+ New User', ['action' => 'add'], ['class' => 'btn btn-dark']) ?>
        </div>
    </div>

    <table>
        <thead>
        <tr>
            <th><?= $this->Paginator->sort('id', 'ID') ?></th>
            <th><?= $this->Paginator->sort('email', 'Email') ?></th>
            <th><?= $this->Paginator->sort('role', 'Role') ?></th>
            <th><?= $this->Paginator->sort('nonce', 'Nonce') ?></th>
            <th><?= $this->Paginator->sort('nonce_expiry', 'Expiry') ?></th>
            <th><?= $this->Paginator->sort('created', 'Created') ?></th>
            <th><?= $this->Paginator->sort('modified', 'Modified') ?></th>
            <th style="text-align:center;">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= h($user->role) ?></td>
                <td><?= h($user->nonce) ?></td>
                <td><?= h($user->nonce_expiry) ?></td>
                <td><?= $user->created ? $user->created->format('Y-m-d H:i') : '' ?></td>
                <td><?= $user->modified ? $user->modified->format('Y-m-d H:i') : '' ?></td>
                <td style="text-align:center;">
                    <?= $this->Html->link(
                        'Details ↗',
                        ['action' => 'view', $user->id],
                        ['class' => 'btn btn-grey']
                    ) ?>
                    <?= $this->Html->link(
                        'Edit ✎',
                        ['action' => 'edit', $user->id],
                        ['class' => 'btn btn-dark']
                    ) ?>
                    <?= $this->Form->postLink(
                        'Delete ✖',
                        ['action' => 'delete', $user->id],
                        [
                            'confirm' => 'Are you sure?',
                            'class'   => 'btn',
                            'style'   => 'background:#c00;color:#fff;'
                        ]
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top:15px; text-align:center;">
        <?= $this->Paginator->prev('‹') ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('›') ?>
    </div>
</div>
