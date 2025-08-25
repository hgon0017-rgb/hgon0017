<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->assign('title', 'Change User Password - Users');

?>
<div class="row">
    <div class="column">
        <div class="users form content">

            <?= $this->Form->create($user) ?>

            <fieldset>

                <legend>Change Password for <u><?= h($user->first_name) ?> <?= h($user->last_name) ?></u></legend>

                <div class="row">
                    <?php
                    echo $this->Form->control('password', [
                        'label' => 'New Password',
                        'value' => '',
                        'templateVars' => ['container_class' => 'column']
                    ]);
                    // Validate password by repeating it
                    echo $this->Form->control('password_confirm', [
                        'type' => 'password',
                        'value' => '',
                        'label' => 'Retype New Password',
                        'templateVars' => ['container_class' => 'column']
                    ]);
                    ?>
                </div>

            </fieldset>

            <?= $this->Form->button('Submit') ?>
            <?= $this->Form->end() ?>

        </div>
    </div>
</div>
