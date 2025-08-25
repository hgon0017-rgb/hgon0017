<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Forgot password');
?>

<style>
    :root{
        --accent:#d35610;
        --text:#1a1a1a;
        --muted:#6b6b6b;
        --ring:#e6e6e6;
        --field:#e9e9e9;
        --card:#ffffff;
    }
    body{
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
        color:var(--text);
        background:#f3f3f3;
    }
    .fp-wrap{
        max-width: 500px;
        margin: 60px auto;
        background: var(--card);
        border-radius: 6px;
        padding: 40px 38px;
        box-shadow: 0 4px 8px rgba(0,0,0,.05);
    }
    .fp-title{
        font-size: 28px;
        font-weight: 800;
        margin: 0 0 22px 0;
        color: var(--accent);
        text-align:center;
    }

    .users.form.content{padding:0; background:transparent; box-shadow:none}

    fieldset{border:0; padding:0; margin:0 0 8px 0}
    legend{display:none}

    label{display:block; font-weight:600; margin:14px 0 6px 0}

    input[type="email"]{
        width:100%;
        appearance:none;
        border:0;
        background: var(--field);
        border-radius: 4px;
        padding: 14px 12px;
        font-size: 16px;
        outline: none;
    }

    .btn-primary{
        width:100%;
        background: var(--accent);
        color:#fff;
        border:0;
        border-radius:4px;
        font-size:16px;
        font-weight:800;
        cursor:pointer;

        height:48px;
        display:flex;
        align-items:center;
        justify-content:center;
        line-height:1;
        text-decoration:none;
        -webkit-appearance:none;
        appearance:none;
    }
    button::-moz-focus-inner{
        border:0;
        padding:0;
    }
    .btn-primary:hover{ filter:brightness(.95); }

    .link-cancel{
        display:block;
        margin-top:18px;
        text-align:center;
        color: var(--accent);
        text-decoration:none;
        font-weight:600;
    }
    .link-cancel:hover{ text-decoration:underline; }
</style>

<div class="fp-wrap">
    <h1 class="fp-title">Forgot your password?</h1>

    <div class="users form content">
        <?= $this->Form->create() ?>
        <fieldset>
            <?php
            echo $this->Form->control('email', [
                'label' => false,
                'type' => 'email',
                'required' => true,
                'placeholder' => 'Enter your email address'
            ]);
            ?>
        </fieldset>

        <!-- RESET-->
        <?= $this->Form->button('RESET', ['class' => 'btn-primary']) ?>
        <?= $this->Form->end() ?>

        <!-- Cancel -->
        <?= $this->Html->link('Cancel', ['controller'=>'Auth','action'=>'login'], ['class'=>'link-cancel']) ?>
    </div>
</div>
