<?php
/**
 * Contact Us index page (Admin style, same scale as Users & Products)
 *
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactU> $contactUs
 */
$this->assign('title', 'Enquiries');
$this->assign('active', 'enquiries'); // highlight sidebar
?>

<div class="content-card">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:15px;">
        <h3 style="margin:0;">Customer Enquiries</h3>
        <!-- Optional button if you want to allow adding enquiries manually -->
        <!-- <?= $this->Html->link('+ New Enquiry', ['action' => 'add'], ['class' => 'btn btn-dark']) ?> -->
    </div>

    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('full_name', "Name") ?></th>
                <th><?= $this->Paginator->sort('email', "Email Address") ?></th>
                <th><?= $this->Paginator->sort('created', "Added On") ?></th>
                <th style="width:180px; text-align:center;">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($contactUs as $contact): ?>
                <tr>
                    <td><?= h($contact->full_name) ?></td>
                    <td><?= h($contact->email) ?></td>
                    <td><?= $contact->created ? $contact->created->format('Y-m-d H:i') : '—' ?></td>
                    <td style="text-align:center;">
                        <?= $this->Html->link('Details ↗', ['action' => 'view', $contact->id], ['class'=>'btn btn-grey']) ?>
                        <?= $this->Form->postLink(
                            'Delete ✖',
                            ['action' => 'delete', $contact->id],
                            ['confirm' => 'Are you sure you want to delete this enquiry?', 'class'=>'btn btn-danger']
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top:15px; text-align:center;">
        <?= $this->Paginator->prev('‹') ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next('›') ?>
    </div>
</div>
