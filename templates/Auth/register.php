<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->layout = 'login';
$this->assign('title', 'Register new user');
?>
<style>
    :root{
        --accent: #292929;
        --text:#1a1a1a;
        --muted:#6b6b6b;
        --ring:#e6e6e6;
        --field:#e9e9e9;
        --card:#f4f4f4;
        --white:#fff;
    }
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;color:var(--text);}
    .register-wrap{
        max-width: 960px;
        margin: 40px auto;
        background: var(--card);
        border-radius: 6px;
        padding: 36px 38px 32px;
    }
    .register-title{
        font-size: 36px;
        font-weight: 800;
        letter-spacing:.3px;
        margin: 0 0 18px 0;
    }
    .users.form.content{padding:0;background:transparent;box-shadow:none}

    fieldset{border:0;padding:0;margin:0}
    legend{display:none}


    .row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    @media (max-width:760px){ .row{grid-template-columns:1fr} }

    label{display:block;font-weight:600;margin:14px 0 6px 0}


    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="file"]{
        width:100%;
        appearance:none;
        border:0;
        background:var(--field);
        border-radius:4px;
        padding:14px 12px;
        font-size:16px;
        outline:none;
    }


    .muted{color:var(--muted);font-size:13px}


    .checkline{display:flex;align-items:center;gap:8px;margin-top:14px;font-size:14px}
    .checkline a{color:var(--accent);text-decoration:none;font-weight:700}
    .checkline a:hover{text-decoration:underline}


    .btn-outline{
        width:100%;
        background:transparent;
        border:2px solid var(--accent);
        color:var(--accent);
        padding:14px 14px;
        border-radius:4px;
        font-size:16px;
        font-weight:800;
        text-align:center;
        cursor:pointer;
        transition:.15s ease;
        text-transform:uppercase;
        letter-spacing:.4px;
    }
    .btn-outline:hover{background:rgba(211,86,16,.06)}


    .btn-link{
        display:inline-block;margin-top:12px;color:var(--accent);text-decoration:none;font-weight:700
    }
    .btn-link:hover{text-decoration:underline}


    .flash{margin:6px 0 10px;color:#b00020}
</style>

<div class="register-wrap">
    <h1 class="register-title">Create your account</h1>

    <div class="users form content">
        <?= $this->Form->create($user) ?>
        <fieldset>

            <?= $this->Flash->render() ?>

            <!-- Email -->
            <?= $this->Form->label('email', 'Email address') ?>
            <?= $this->Form->control('email', ['label'=>false]) ?>

            <!-- First / Last name -->
            <div class="row">
                <div>
                    <?= $this->Form->label('first_name', 'First name') ?>
                    <?= $this->Form->control('first_name', ['label'=>false]) ?>
                </div>
                <div>
                    <?= $this->Form->label('last_name', 'Last name') ?>
                    <?= $this->Form->control('last_name', ['label'=>false]) ?>
                </div>
            </div>

            <!-- Password / Confirm -->
            <div class="row">
                <div>
                    <?= $this->Form->label('password', 'Choose your password') ?>
                    <?= $this->Form->control('password', [
                        'label'=>false,
                        'value' => ''
                    ]) ?>
                </div>
                <div>
                    <?= $this->Form->label('password_confirm', 'Retype password') ?>
                    <?= $this->Form->control('password_confirm', [
                        'type'=>'password',
                        'label'=>false,
                        'value' => ''
                    ]) ?>
                </div>
            </div>

            <!-- Avatar -->
            <div style="margin-top:14px">
                <?= $this->Form->label('avatar', 'Avatar (optional)') ?>
                <?= $this->Form->control('avatar', ['type'=>'file', 'label'=>false]) ?>
                <div class="muted">JPG/PNG，Max 2MB</div>
            </div>

            <!-- 订阅与协议 -->
            <label class="checkline">
                <?= $this->Form->checkbox('subscribe', ['value'=>1]) ?>
                Click here to receive the latest offers and inspiration
            </label>
            <label class="checkline">
                <?= $this->Form->checkbox('terms', ['required'=>true]) ?>
                I agree to the <a href="#">Terms &amp; Conditions</a>
            </label>

        </fieldset>

        <!-- REGISTER -->
        <?= $this->Form->button('REGISTER', ['class'=>'btn-outline']) ?>

        <!-- Back to Login-->
        <?= $this->Html->link('Back to login', ['controller'=>'Auth','action'=>'login'], ['class'=>'btn-link']) ?>

        <?= $this->Form->end() ?>
    </div>
</div>
