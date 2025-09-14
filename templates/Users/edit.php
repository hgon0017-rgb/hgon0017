<?php
/**
 * Users Edit (Admin UI same scale as Users index / Products dashboard)
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
    <!-- Main -->
    <main>
        <div class="content-card">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <h3 style="margin:0">Edit User</h3>
                <div>
                    <?= $this->Form->postLink(
                        'Delete ✖',
                        ['action' => 'delete', $user->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-danger']
                    ) ?>
                    <?= $this->Html->link('← Back to Users', ['action' => 'index'], ['class' => 'btn btn-grey']) ?>
                </div>
            </div>

            <div style="margin-top:12px;">
                <?= $this->Form->create($user, ['autocomplete' => 'off']) ?>

                <div class="form-grid">
                    <div class="input">
                        <?= $this->Form->label('email', 'Email') ?>
                        <?= $this->Form->control('email', [
                            'label' => false,
                            'type' => 'email',
                            'placeholder' => 'name@example.com'
                        ]) ?>
                    </div>

                    <div class="input">
                        <?= $this->Form->label('password', 'Password') ?>
                        <?= $this->Form->control('password', [
                            'label' => false,
                            'type' => 'password',
                            'value' => '',
                            'placeholder' => 'Leave blank to keep unchanged'
                        ]) ?>
                    </div>

                    <div class="input">
                        <?= $this->Form->label('role', 'Role') ?>
                        <?= $this->Form->control('role', [
                            'label' => false,
                            'type'  => 'select',
                            'options' => ['customer' => 'customer', 'admin' => 'admin'],
                            'empty' => false
                        ]) ?>
                    </div>

                    <div class="input">
                        <?= $this->Form->label('nonce', 'Nonce') ?>
                        <?= $this->Form->control('nonce', [
                            'label' => false,
                            'placeholder' => 'Optional one-time token'
                        ]) ?>
                    </div>

                    <div class="input">
                        <?= $this->Form->label('nonce_expiry', 'Nonce Expiry') ?>
                        <?= $this->Form->control('nonce_expiry', [
                            'label' => false,
                            'type'  => 'datetime-local',
                        ]) ?>
                    </div>
                </div>

                <div style="margin-top:12px;">
                    <?= $this->Form->button('Save Changes', ['class' => 'btn btn-dark']) ?>
                    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn']) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </main>

</div>
