<?php
/**
 * Users Add (Admin UI same scale as Users index / Products dashboard)
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Add User');
?>

<div class="content-card">
    <div style="display:flex; align-items:center; justify-content:space-between;">
        <h3 style="margin:0">Add User</h3>
        <div>
            <?= $this->Html->link('← Back to Users', ['action' => 'index'], ['class' => 'btn btn-grey']) ?>
        </div>
    </div>

    <div style="margin-top:12px;">
        <?= $this->Form->create($user, ['novalidate' => true]) ?>

        <div class="form-grid">
            <!-- Email -->
            <div class="input">
                <?= $this->Form->label('email', 'Email') ?>
                <?= $this->Form->control('email', [
                    'label' => false,
                    'type' => 'email',
                    'placeholder' => 'name@example.com',
                    'required' => true
                ]) ?>
                <?= $this->Form->error('email', null, ['class' => 'error-message']) ?>
            </div>

            <!-- Password (with toggle) -->
            <div class="input password-wrap">
                <?= $this->Form->label('password', 'Password') ?>
                <?= $this->Form->control('password', [
                    'label' => false,
                    'type' => 'password',
                    'placeholder' => 'Set a secure password',
                    'required' => true,
                    'id' => 'pass-input'
                ]) ?>
                <button type="button" class="toggle-pass" id="toggle-pass">SHOW</button>
                <?= $this->Form->error('password', null, ['class' => 'error-message']) ?>
            </div>

            <!-- Role -->
            <div class="input">
                <?= $this->Form->label('role', 'Role') ?>
                <?= $this->Form->control('role', [
                    'label' => false,
                    'type'  => 'select',
                    'options' => ['customer' => 'customer', 'admin' => 'admin'],
                    'default' => 'customer',
                    'empty' => false
                ]) ?>
                <?= $this->Form->error('role', null, ['class' => 'error-message']) ?>
            </div>

            <!-- Nonce -->
            <div class="input">
                <?= $this->Form->label('nonce', 'Nonce') ?>
                <?= $this->Form->control('nonce', [
                    'label' => false,
                    'placeholder' => 'Optional one-time token'
                ]) ?>
                <?= $this->Form->error('nonce', null, ['class' => 'error-message']) ?>
            </div>

            <!-- Nonce expiry -->
            <div class="input">
                <?= $this->Form->label('nonce_expiry', 'Nonce Expiry') ?>
                <?= $this->Form->control('nonce_expiry', [
                    'label' => false,
                    'type'  => 'datetime-local',
                    'empty' => true
                ]) ?>
                <?= $this->Form->error('nonce_expiry', null, ['class' => 'error-message']) ?>
            </div>
        </div>

        <div style="margin-top:12px;">
            <?= $this->Form->button('Create User', ['class' => 'btn btn-dark']) ?>
            <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn']) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<script>
    (function () {
        const btn = document.getElementById('toggle-pass');
        const input = document.getElementById('pass-input');
        if (!btn || !input) return;
        btn.addEventListener('click', () => {
            const show = input.getAttribute('type') === 'password';
            input.setAttribute('type', show ? 'text' : 'password');
            btn.textContent = show ? 'HIDE' : 'SHOW';
        });
    })();
</script>
