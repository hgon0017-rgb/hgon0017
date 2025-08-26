<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>
<div class="users index content">

    <h3><?= __('Users') ?></h3>
    <?= $this->Html->link(
        '+ New User',
        ['action' => 'add'],
        [
            'style' => 'display:inline-block;padding:4px 8px;background:#333;color:#fff;
                        text-decoration:none;border-radius:4px;font-size:12px;margin:5px 0;'
        ]
    ) ?>

    <br><br>

    <table style="width:100%; border-collapse:collapse; font-size:13px;">
        <thead>
        <tr style="background:#f2f2f2; text-align:left;">
            <th style="border:1px solid #ccc; padding:8px;"><?= $this->Paginator->sort('id', 'ID') ?></th>
            <th style="border:1px solid #ccc; padding:8px;"><?= $this->Paginator->sort('email', 'Email') ?></th>
            <th style="border:1px solid #ccc; padding:8px;"><?= $this->Paginator->sort('nonce', 'Nonce') ?></th>
            <th style="border:1px solid #ccc; padding:8px;"><?= $this->Paginator->sort('nonce_expiry', 'Expiry') ?></th>
            <th style="border:1px solid #ccc; padding:8px;"><?= $this->Paginator->sort('created', 'Created') ?></th>
            <th style="border:1px solid #ccc; padding:8px;"><?= $this->Paginator->sort('modified', 'Modified') ?></th>
            <th style="border:1px solid #ccc; padding:8px; text-align:center;">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $rowIndex = 0; ?>
        <?php foreach ($users as $user): ?>
            <tr style="background:<?= $rowIndex % 2 == 0 ? '#fff' : '#fafafa' ?>;">
                <td style="border:1px solid #ccc; padding:8px;"><?= $this->Number->format($user->id) ?></td>
                <td style="border:1px solid #ccc; padding:8px;"><?= h($user->email) ?></td>
                <td style="border:1px solid #ccc; padding:8px;"><?= h($user->nonce) ?></td>
                <td style="border:1px solid #ccc; padding:8px;"><?= h($user->nonce_expiry) ?></td>
                <td style="border:1px solid #ccc; padding:8px;"><?= $user->created ? $user->created->format('Y-m-d H:i') : '' ?></td>
                <td style="border:1px solid #ccc; padding:8px;"><?= $user->modified ? $user->modified->format('Y-m-d H:i') : '' ?></td>
                <td style="border:1px solid #ccc; padding:8px; text-align:center;">
                    <?= $this->Html->link(
                        'Details ↗',
                        ['action' => 'view', $user->id],
                        ['style' => 'display:inline-block;padding:2px 6px;background:#666;color:#fff;
                                     text-decoration:none;border-radius:3px;font-size:11px;margin-right:3px;']
                    ) ?>
                    <?= $this->Html->link(
                        'Edit ✎',
                        ['action' => 'edit', $user->id],
                        ['style' => 'display:inline-block;padding:2px 6px;background:#444;color:#fff;
                                     text-decoration:none;border-radius:3px;font-size:11px;margin-right:3px;']
                    ) ?>
                    <?= $this->Form->postLink(
                        'Delete ✖',
                        ['action' => 'delete', $user->id],
                        [
                            'confirm' => __('Are you sure you want to delete # {0}?', $user->id),
                            'style'   => 'display:inline-block;padding:2px 6px;background:#c00;color:#fff;
                                          text-decoration:none;border-radius:3px;font-size:11px;'
                        ]
                    ) ?>
                </td>
            </tr>
            <?php $rowIndex++; endforeach; ?>
        </tbody>
    </table>

    <br>


    <div style="margin-top:15px; font-size:14px; text-align:center;">


        <?= $this->Paginator->prev('‹', [
            'escape' => false,
            'disabledTag' => '<span style="margin:0 8px;color:#ccc;font-size:16px;">‹</span>',
            'style' => 'margin:0 8px;color:#666;text-decoration:none;font-size:16px;'
        ]) ?>


        <?= $this->Paginator->numbers([
            'before' => '',
            'after' => '',
            'separator' => ' ',
            'modulus' => 5,
            'currentTag' => 'span',
            'currentClass' => 'active',
            'templates' => [
                'number' => '<a href="{{url}}" style="margin:0 8px;color:#666;
                             text-decoration:none;font-size:14px;">{{text}}</a>',
                'current' => '<span style="margin:0 8px;font-weight:bold;color:#000;
                               border-bottom:2px solid blue;font-size:14px;">{{text}}</span>'
            ]
        ]) ?>


        <?= $this->Paginator->next('›', [
            'escape' => false,
            'disabledTag' => '<span style="margin:0 8px;color:#ccc;font-size:16px;">›</span>',
            'style' => 'margin:0 8px;color:#666;text-decoration:none;font-size:16px;'
        ]) ?>

    </div>
</div>
