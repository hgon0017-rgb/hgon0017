<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactU> $contactUs
 */
$this->assign('title', 'Customer Enquiries');
?>

    <main>
        <div class="content-card">
            <h3>Customer Enquiries</h3>

            <div class="table-responsive">
                <table>
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('full_name', "Name") ?></th>
                        <th><?= $this->Paginator->sort('email', "Email Address") ?></th>
                        <th><?= $this->Paginator->sort('created', "Added On") ?></th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($contactUs as $contact): ?>
                        <tr>
                            <td><?= h($contact->full_name) ?></td>
                            <td><?= h($contact->email) ?></td>
                            <td><?= $contact->created ? $contact->created->format('Y-m-d H:i') : '' ?></td>
                            <td>
                                <?= $this->Html->link('View ↗', ['action' => 'view', $contact->id], ['class'=>'btn btn-grey']) ?>
                                <?= $this->Form->postLink('Delete ✖',
                                    ['action' => 'delete', $contact->id],
                                    ['confirm' => 'Are you sure you want to delete this enquiry?', 'class'=>'btn', 'style'=>'background:#c00;color:#fff;']
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top:15px; text-align:center;">
                <?= $this->Paginator->prev('‹') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('›') ?>
            </div>
        </div>
    </main>
</div>
