<?php
/**
 * Users Add (Admin UI same scale as Users index / Products dashboard)
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Add User');

$productsUrl = $this->Url->build(['controller' => 'Products', 'action' => 'dashboard']);
$usersUrl    = $this->Url->build(['controller' => 'Users',    'action' => 'index']);
$contactsUrl = $this->Url->build(['controller' => 'ContactUs','action' => 'index']);
?>

<style>
    /* === Same scale as users index === */
    .admin-shell { display:grid; grid-template-columns:220px 1fr; gap:20px; max-width:1400px; margin:0 auto; padding:20px; }
    .sidebar { background:#f8fafc; border:1px solid #e5e7eb; border-radius:12px; padding:14px; }
    .sidebar h4 { margin:6px 10px 12px; font-size:18px; }
    .nav-list{ list-style:none; padding:0; margin:0; }
    .nav-list li{ margin:4px 0; }
    .nav-link{ display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; text-decoration:none;
        color:#111827; background:#fff; border:1px solid #e5e7eb; }
    .nav-link.active{ background:#e9efff; border-color:#c7d2fe; font-weight:700; }

    .content-card{ background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:18px; }
    .btn { display:inline-block; padding:8px 12px; border-radius:6px; font-size:13px; text-decoration:none; margin-left:6px; }
    .btn-dark { background:#333; color:#fff; }
    .btn-grey { background:#555; color:#fff; }
    .btn-danger { background:#c00; color:#fff; }

    form .input { margin-bottom:14px; }
    label { font-weight:600; display:block; margin-bottom:6px; }
    input[type="text"], input[type="email"], input[type="password"], input[type="datetime-local"], select, textarea {
        width:100%; padding:8px 10px; border:1px solid #ccc; border-radius:6px; font-size:14px;
    }

    /* two-column form */
    .form-grid{ display:grid; grid-template-columns:1fr 1fr; gap:16px 20px; }
    @media (max-width: 720px){ .form-grid{ grid-template-columns:1fr; } }

    .error-message{ margin-top:6px; color:#dc2626; font-size:13px; font-weight:600; }
    .toggle-pass{ position:absolute; right:10px; top:50%; transform:translateY(-50%); border:0; background:transparent; cursor:pointer; color:#6b7280; font-size:12px; font-weight:700; }
    .password-wrap{ position:relative; }
</style>

<div class="admin-shell">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h4>Admin</h4>
        <ul class="nav-list">
            <li><a class="nav-link"        href="<?= $productsUrl ?>">🛒 Products</a></li>
            <li><a class="nav-link active" href="<?= $usersUrl ?>">👥 Users</a></li>
            <li><a class="nav-link"        href="<?= $contactsUrl ?>">📩 Enquiries</a></li>
        </ul>
    </aside>

    <!-- Main -->
    <main>
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
    </main>

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
