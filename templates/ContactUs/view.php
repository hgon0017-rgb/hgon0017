<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactU $contactU
 */
?>
<div class="row">
    </aside>
    <div class="column">
        <div class="contactUs view content">
            <h3>Enquiry from <b><?= h($contactU->full_name) ?></b></h3>
            <table>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= $this->Html->link(h($contactU->email), 'mailto:'.$contactU->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($contactU->created->i18nFormat(null, 'Australia/Melbourne')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email Sent') ?></th>
                    <td><?= $contactU->email_sent ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($contactU->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
