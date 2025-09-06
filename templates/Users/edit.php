<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Edit User');

// 格式化 datetime-local 的值
$nonceExpiryValue = '';
if (!empty($user->nonce_expiry)) {
    try {
        $dt = $user->nonce_expiry instanceof \DateTimeInterface
            ? $user->nonce_expiry
            : new \DateTime($user->nonce_expiry);
        $nonceExpiryValue = $dt->format('Y-m-d\TH:i');
    } catch (\Throwable $e) { $nonceExpiryValue = ''; }
}
?>

<style>
    :root{ --bg:#f6f7fb; --card:#fff; --ring:#e9e9ee; --muted:#6b7280; --text:#111827;
        --primary:#000; --primary-2:#222; --danger:#dc2626; }
    .users-edit-body{ background: var(--bg); padding:24px 16px 48px; }
    .card-wrap{ max-width: 860px; margin:0 auto; background:#fff; border:1px solid var(--ring);
        border-radius:16px; box-shadow:0 10px 28px rgba(0,0,0,.06); overflow:hidden; }
    .card-head{ padding:22px 24px; border-bottom:1px solid var(--ring);
        display:flex; justify-content:space-between; align-items:center; }
    .card-title{ margin:0; font-size:22px; font-weight:800; color:var(--text); }
    .btn-link{ display:inline-flex; gap:6px; align-items:center; background:#fff; border:1px solid var(--ring);
        color:var(--text); padding:8px 12px; border-radius:10px; text-decoration:none; font-weight:600; }
    .btn-link:hover{ background:#fafafa; }
    .card-body{ padding:22px 24px 28px; }
    .form-grid{ display:grid; grid-template-columns:1fr 1fr; gap:16px 20px; }
    @media (max-width: 720px){ .form-grid{ grid-template-columns:1fr; } }
    .form-field label{ display:block; font-weight:700; margin-bottom:8px; color:var(--text); }
    .form-field input, .form-field select{
        width:100%; border:1px solid var(--ring); border-radius:10px; padding:12px 12px; font-size:15px;
        outline:none; background:#fff; transition: box-shadow .15s, border-color .15s;
    }
    .form-field input:focus, .form-field select:focus{
        border-color:var(--primary); box-shadow:0 0 0 3px rgba(0,0,0,.12);
    }
    .field-help{ font-size:12px; color:var(--muted); margin-top:6px; }
    .form-actions{ display:flex; gap:12px; margin-top:8px; }
    .btn-primary{ background:var(--primary); color:#fff; border:none; border-radius:10px; padding:12px 16px; font-weight:800; cursor:pointer; }
    .btn-primary:hover{ background:var(--primary-2); }
    .btn-ghost{ background:#fff; color:var(--text); border:1px solid var(--ring); border-radius:10px; padding:12px 16px; text-decoration:none; font-weight:700; }
    .btn-ghost:hover{ background:#fafafa; }
    .password-wrap{ position:relative; }
    .toggle-pass{ position:absolute; right:10px; top:50%; transform:translateY(-50%); border:0; background:transparent; cursor:pointer; color:#6b7280; font-size:13px; font-weight:700; }
</style>

<div class="users-edit-body">
    <div class="card-wrap">
        <div class="card-head">
            <h2 class="card-title">Edit User</h2>
            <?= $this->Html->link('← Back to Users', ['action' => 'index'], ['class' => 'btn-link']) ?>
        </div>

        <div class="card-body">
            <?= $this->Form->create($user, ['autocomplete' => 'off']) ?>

            <div class="form-grid">
                <!-- Email -->
                <div class="form-field">
                    <?= $this->Form->label('email', 'Email') ?>
                    <?= $this->Form->control('email', [
                        'label' => false, 'type' => 'email', 'placeholder' => 'name@example.com',
                    ]) ?>
                    <div class="field-help">We’ll never share your email.</div>
                </div>

                <!-- Password（不回显旧值） -->
                <div class="form-field password-wrap">
                    <?= $this->Form->label('password', 'Password') ?>
                    <?= $this->Form->control('password', [
                        'label' => false, 'type' => 'password', 'value' => '',
                        'placeholder' => 'Set a secure password', 'id' => 'pwd',
                    ]) ?>
                    <button type="button" class="toggle-pass" id="togglePwd">SHOW</button>
                    <div class="field-help">At least 8 characters is recommended.</div>
                </div>

                <!-- Role (customer/admin) -->
                <div class="form-field">
                    <?= $this->Form->label('role', 'Role') ?>
                    <?= $this->Form->control('role', [
                        'label' => false, 'type' => 'select',
                        'options' => ['customer' => 'customer', 'admin' => 'admin'],
                        'empty' => false,
                    ]) ?>
                </div>

                <!-- Nonce -->
                <div class="form-field">
                    <?= $this->Form->label('nonce', 'Nonce') ?>
                    <?= $this->Form->control('nonce', ['label' => false, 'placeholder' => 'Optional one-time token']) ?>
                    <div class="field-help">Optional token for verification or invitations.</div>
                </div>

                <!-- Nonce Expiry -->
                <div class="form-field">
                    <?= $this->Form->label('nonce_expiry', 'Nonce Expiry') ?>
                    <?= $this->Form->control('nonce_expiry', [
                        'label' => false, 'type' => 'datetime-local', 'value' => $nonceExpiryValue,
                    ]) ?>
                    <div class="field-help">Leave empty if the token does not expire.</div>
                </div>
            </div>

            <div class="form-actions">
                <?= $this->Form->button('Save Changes', ['class' => 'btn-primary']) ?>
                <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn-ghost']) ?>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
    (function(){
        const btn = document.getElementById('togglePwd');
        const input = document.getElementById('pwd');
        if (!btn || !input) return;
        btn.addEventListener('click', () => {
            const show = input.getAttribute('type') === 'password';
            input.setAttribute('type', show ? 'text' : 'password');
            btn.textContent = show ? 'HIDE' : 'SHOW';
        });
    })();
</script>
