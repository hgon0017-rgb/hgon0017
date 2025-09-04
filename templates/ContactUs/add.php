<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactU $contactU
 */
$this->assign('title', 'Contact Us');
?>

<style>
    :root {
        --accent: #000000;       /* 纯黑 */
        --accent-hover: #222222; /* 悬停时稍微浅一点的黑灰 */
        --text: #1a1a1a;
        --muted: #6b6b6b;
        --bg: #f6f7fb;
        --card: #ffffff;
        --ring: #e6e6e6;
        --field: #fdfdfd;
    }

    body {
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
        background: var(--bg);
        color: var(--text);
    }

    .contact-form {
        max-width: 720px;
        margin: 36px auto 56px;
        background: var(--card);
        padding: 36px 40px 44px;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(0,0,0,.06);
    }

    .contact-form h3 {
        font-size: 32px;
        font-weight: 800;
        color: var(--accent);   /* 纯黑标题 */
        margin-bottom: 22px;
        text-align: center;
        letter-spacing: .3px;
    }

    label {
        font-weight: 700;
        margin: 14px 0 8px;
        display: block;
        color: var(--text);
    }

    input[type="text"],
    input[type="email"],
    textarea {
        width: 100%;
        padding: 14px 12px;
        border-radius: 10px;
        border: 1px solid var(--ring);
        background: var(--field);
        font-size: 16px;
        outline: none;
        transition: box-shadow .15s ease, border-color .15s ease;
    }

    textarea {
        min-height: 130px;
        resize: vertical;
    }

    input:focus,
    textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(0,0,0,.15); /* 黑色阴影 */
    }

    .checkbox {
        margin: 10px 0 4px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text);
        font-weight: 600;
    }

    .checkbox input[type="checkbox"]{
        width: 18px;
        height: 18px;
        accent-color: var(--accent);
        cursor: pointer;
    }

    .btn-submit {
        width: 100%;
        background: var(--accent);   /* 纯黑按钮 */
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        margin-top: 18px;

        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        text-decoration: none;
        -webkit-appearance: none;
        appearance: none;
    }
    button::-moz-focus-inner { border: 0; padding: 0; }
    .btn-submit:hover { background: var(--accent-hover); }
    .btn-submit:focus { outline: none; box-shadow: 0 0 0 3px rgba(0,0,0,.2); }
</style>

<div class="contact-form">
    <h3>Send new enquiry</h3>

    <?= $this->Form->create($contactU) ?>
    <?= $this->Form->control('full_name', ['label' => 'Your full name']) ?>
    <?= $this->Form->control('email', ['label' => 'Your email address']) ?>
    <?= $this->Form->control('body', ['label' => 'Any enquiries', 'type' => 'textarea']) ?>

    <label class="checkbox">
        <?= $this->Form->control('email_sent', ['type' => 'checkbox', 'label' => false]) ?>
        <span>Email Sent</span>
    </label>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div class="g-recaptcha" data-sitekey="<?= h(\Cake\Core\Configure::read('Recaptcha.siteKey')) ?>"></div>

    <?= $this->Form->button('SEND ENQUIRY', ['class' => 'btn-submit']) ?>
    <?= $this->Form->end() ?>
</div>
