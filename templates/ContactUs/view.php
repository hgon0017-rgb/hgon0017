<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactU $contactU
 */
$this->assign('title', 'Enquiry Details');
$this->assign('active', 'enquiries'); // highlight Enquiries in sidebar
?>

<div class="content-card">
    <!-- Header with actions -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:15px;">
        <h3 style="margin:0;">Enquiry from <b><?= h($contactU->full_name) ?></b></h3>
        <div>
            <?= $this->Html->link('← Back to Enquiries', ['action' => 'index'], ['class' => 'btn btn-grey']) ?>
            <?= $this->Form->postLink('Delete ✖',
                ['action' => 'delete', $contactU->id],
                ['confirm' => 'Are you sure you want to delete this enquiry?', 'class'=>'btn btn-danger']
            ) ?>
        </div>
    </div>

    <!-- Details Table -->
    <div class="table-responsive">
        <table>
            <tbody>
            <tr>
                <th style="width:200px;">Name</th>
                <td><?= h($contactU->full_name) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= $this->Html->link(h($contactU->email), 'mailto:'.$contactU->email) ?></td>
            </tr>
            <tr>
                <th>Created</th>
                <td><?= $contactU->created ? $contactU->created->i18nFormat('yyyy-MM-dd HH:mm', 'Australia/Melbourne') : '—' ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Description box -->
    <div style="margin-top:20px;">
        <strong><?= __('Description') ?></strong>
        <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:12px; margin-top:8px;">
            <?= $this->Text->autoParagraph(h($contactU->description)); ?>
        </div>
    </div>
</div>
