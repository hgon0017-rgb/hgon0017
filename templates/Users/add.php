<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Add User');
?>

<style>
    :root{
        --bg:#f6f7fb; --card:#fff; --ring:#e9e9ee; --muted:#6b7280; --text:#111827;
        --primary:#000; --primary-2:#222; --ok:#16a34a; --danger:#dc2626;
    }
    .users-add-body{ background: var(--bg); padding: 24px 16px 48px; }
    .card-wrap{
        max-width: 860px; margin: 0 auto; background: var(--card);
        border: 1px solid var(--ring); border-radius: 16px;
        box-shadow: 0 10px 28px rgba(0,0,0,.06); overflow: hidden;
    }
    .card-head{
        padding: 22px 24px; border-bottom: 1px solid var(--ring);
        display:flex; align-items:center; justify-content:space-between; gap:12px;
    }
    .card-title{ font-size: 22px; font-weight: 800; color: var(--text); margin: 0; }
    .btn-link{
        display:inline-flex; gap:6px; align-items:center; background:#fff;
        border:1px solid var(--ring); color:var(--text); padding:8px 12px;
        border-radius:10px; text-decoration:none; font-weight:600;
    }
    .btn-link:hover{ background:#fafafa; }
    .card-body{ padding: 22px 24px 28px; }
    .form-grid{ display:grid; grid-template-columns:1fr 1fr; gap:16px 20px; }
    @media (max-width: 720px){ .form-grid{ grid-template-columns:1fr; } }
    .form-field label{ display:block; font-weight:700; margin-bottom:8px; color:var(--text); }
    .form-field input, .form-field textarea, .form-field select{
        width:100%; border:1px solid var(--ring); border-radius:10px; padding:12px 12px;
        font-size:15px; outline:none; background:#fff; transition: box-shadow .15s, border-color .15s;
    }
    .form-field input:focus, .form-field select:focus{
        border-color: var(--primary); box-shadow: 0 0 0 3px rgba(0,0,0,.12);
    }
    .field-help{ font-size:12px; color:var(--muted); margin-top:6px; }
    .error-message{ margin-top:6px; color:var(--danger); font-size:13px; font-weight:600; }
    .form-actions{ display:flex; gap:12px; margin-top: 8px; }
    .btn-primary{
        background:var(--primary); color:#fff; border:none; border-radius:10px;
        padding:12px 16px; font-weight:800; cursor:pointer;
    }
    .btn-primary:hover{ background:var(--primary-2); }
    .btn-ghost{
        background:#fff; color:var(--text); border:1px solid var(--ring);
        border-radius:10px; padding:12px 16px; text-decoration:none; font-weight:700;
    }
    .btn-ghost:hover{ background:#fafafa; }
    .password-wrap{ position:relative; }
    .toggle-pass{
        position:absolute; right:10px; top:50%; transform: translateY(-50%);
        border:0; background:transparent; cursor:pointer; color:var(--muted);
        font-size:13px; font-weight:700;
    }
    .toggle-pass:focus{ outline:none; color:var(--text); }
</style>

<div class="users-add-body">
    <div class="card-wrap">
        <div class="card-head">
            <h2 class="card-title">Add User</h2>
            <div class="actions-inline">
                <?= $this->Html->link('← Back to Users', ['action' => 'index'], ['class' => 'btn-link']) ?>
            </div>
        </div>

        <div class="card-body">
            <?= $this->Form->create($user, ['novalidate' => true]) ?>

            <div class="form-grid">
                <!-- Email -->
                <div class="form-field">
                    <?= $this->Form->label('email', 'Email') ?>
                    <?= $this->Form->control('email', [
                        'label' => false, 'type' => 'email',
                        'placeholder' => 'name@example.com', 'required' => true,
                    ]) ?>
                    <div class="field-help">We’ll never share your email.</div>
                    <?= $this->Form->error('email', null, ['class' => 'error-message']) ?>
                </div>

                <!-- Password + toggle -->
                <div class="form-field password-wrap">
                    <?= $this->Form->label('password', 'Password') ?>
                    <?= $this->Form->control('password', [
                        'label' => false, 'type' => 'password',
                        'placeholder' => 'Set a secure password', 'required' => true,
                        'id' => 'pass-input'
                    ]) ?>
                    <button type="button" class="toggle-pass" id="toggle-pass">SHOW</button>
                    <div class="field-help">At least 8 characters is recommended.</div>
                    <?= $this->Form->error('password', null, ['class' => 'error-message']) ?>
                </div>

                <!-- Role (customer/admin) -->
                <div class="form-field">
                    <?= $this->Form->label('role', 'Role') ?>
                    <?= $this->Form->control('role', [
                        'label' => false, 'type' => 'select',
                        'options' => ['customer' => 'customer', 'admin' => 'admin'],
                        'default' => 'customer', 'empty' => false,
                    ]) ?>
                    <?= $this->Form->error('role', null, ['class' => 'error-message']) ?>
                </div>

                <!-- Nonce -->
                <div class="form-field">
                    <?= $this->Form->label('nonce', 'Nonce') ?>
                    <?= $this->Form->control('nonce', [
                        'label' => false, 'placeholder' => 'Optional one-time token',
                    ]) ?>
                    <div class="field-help">Optional token for verification or invitations.</div>
                    <?= $this->Form->error('nonce', null, ['class' => 'error-message']) ?>
                </div>

                <!-- Nonce Expiry -->
                <div class="form-field">
                    <?= $this->Form->label('nonce_expiry', 'Nonce Expiry') ?>
                    <?= $this->Form->control('nonce_expiry', [
                        'label' => false, 'type' => 'datetime-local', 'empty' => true,
                    ]) ?>
                    <div class="field-help">Leave empty if the token does not expire.</div>
                    <?= $this->Form->error('nonce_expiry', null, ['class' => 'error-message']) ?>
                </div>
            </div>

            <div class="form-actions">
                <?= $this->Form->button('Create User', ['class' => 'btn-primary']) ?>
                <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn-ghost']) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
    (function(){
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
