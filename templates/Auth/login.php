<?php
/**
 * @var \App\View\AppView $this
 */
use Cake\Core\Configure;

$debug = Configure::read('debug');

$this->layout = 'login';
$this->assign('title', 'Login');
?>
<style>
    :root{
        --accent:#d35610;
        --text:#1a1a1a;
        --muted:#6b6b6b;
        --ring:#e6e6e6;
        --field:#e9e9e9;
        --card:#f4f4f4;
    }
    body{font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; color:var(--text);}
    .login-wrap{
        max-width: 820px;
        margin: 40px auto;
        background: var(--card);
        border-radius: 6px;
        padding: 36px 38px 40px;
    }
    .login-title{
        font-size: 32px;
        font-weight: 800;
        margin: 0 0 22px 0;
    }

    .users.form.content{padding:0; background:transparent; box-shadow:none}

    fieldset{border:0; padding:0; margin:0 0 8px 0}
    legend{display:none}

    label{display:block; font-weight:600; margin:14px 0 6px 0}

    input[type="email"], input[type="password"]{
        width:100%;
        appearance:none;
        border:0;
        background: var(--field);
        border-radius: 4px;
        padding: 14px 12px;
        font-size: 16px;
        outline: none;
    }

    .link-muted{
        display:inline-block;
        margin: 10px 0 20px;
        color: var(--accent);
        text-decoration: none;
        font-weight: 700;
    }
    .link-muted:hover{ text-decoration: underline; }

    .btn-primary{
        width:100%;
        background: var(--accent);
        color:#fff;
        border:0;
        padding: 16px 14px;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 800;
        cursor:pointer;
        letter-spacing:.4px;
    }
    .btn-primary:hover{ filter:brightness(.95); }

    .btn-outline{
        width:100%;
        background: transparent;
        border: 2px solid var(--accent);
        color: var(--accent);
        padding: 14px 14px;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 800;
        text-align:center;
        display:inline-block;
    }
    .btn-outline:hover{ background: rgba(211,86,16,.06); }

    .between{ height:18px; }
    .flash{ margin: 6px 0 10px; color:#b00020; }
</style>

<div class="login-wrap">
    <h1 class="login-title">Login to your account</h1>

    <div class="users form content">
        <?= $this->Form->create() ?>

        <fieldset>
            <?= $this->Flash->render() ?>

            <?php
            echo $this->Form->label('email', 'Email');
            echo $this->Form->control('email', [
                'label' => false,
                'type' => 'email',
                'required' => true,
                'autofocus' => true,
                'value' => $debug ? "test@example.com" : "",
            ]);

            echo $this->Form->label('password', 'Password');
            echo $this->Form->control('password', [
                'label' => false,
                'type' => 'password',
                'required' => true,
                'value' => $debug ? '' : '',
            ]);
            ?>
        </fieldset>

        <!-- Forgot password  skip to Pages/forgetpassword -->
        <?= $this->Html->link('Forgot password?',
            ['controller' => 'Pages', 'action' => 'display', 'forgetpassword'],
            ['class' => 'link-muted']) ?>

        <!-- LOGIN -->
        <?= $this->Form->button('LOGIN', ['class' => 'btn-primary']) ?>
        <div class="between"></div>

        <!-- CREATE ACCOUNT -->
        <?= $this->Html->link('CREATE ACCOUNT',
            ['controller' => 'Auth', 'action' => 'register'],
            ['class' => 'btn-outline']) ?>

        <?= $this->Form->end() ?>
    </div>
</div>
