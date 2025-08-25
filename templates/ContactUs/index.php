<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactU> $contactUs
 */
?>
<div class="contactUs index content">
    <?= $this->Html->link(__('Contact Us'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Contact Us') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('full_name', "Name") ?></th>
                <th><?= $this->Paginator->sort('email', "Email Address") ?></th>
                <th><?= $this->Paginator->sort('created', "Added On") ?></th>
                <th><?= $this->Paginator->sort('email_sent', "Sent?") ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($contactUs as $contact): ?>
                <tr>
                    <td><?= h($contact->full_name) ?></td>
                    <td><?= h($contact->email) ?></td>
                    <td><?= h($contact->created) ?></td>
                    <td><?= $contact->email_sent ? __('Yes') : __('No') ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $contact->id]) ?>
                        <?= $this->Html->link(__('Mark as sent'), ['action' => 'mark', $contact->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $contact->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $contact->id),
                            ]
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
