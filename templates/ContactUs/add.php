<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactU $contactU
 */
$this->assign('title', 'Contact Us');
?>

<style>
    /* ===== Contact page (professional, brand-consistent) ===== */
    :root{
        --bg: #f6f7fb;
        --text:#1a1a1a;
        --muted:#6b6b6b;
        --card:#ffffff;
        --ring:#e6e6e6;
        --field:#fdfdfd;
        --accent:#000;          /* brand black */
        --accent-2:#222;        /* hover */
    }

    body{ background:var(--bg); color:var(--text); }

    .contact-wrap{
        max-width: 1100px;
        margin: 28px auto 64px;
        padding: 0 22px;
    }

    .contact-title{
        font-size: 34px; font-weight: 900; letter-spacing:.2px;
        margin: 10px 0 18px 0;
    }

    .contact-grid{
        display:grid;
        grid-template-columns: 1.05fr 1fr;
        gap: 28px;
    }
    @media (max-width: 960px){
        .contact-grid{ grid-template-columns: 1fr; }
    }

    /* Info column (left) */
    .info{
        background: var(--card);
        border:1px solid var(--ring);
        border-radius: 14px;
        padding: 26px 26px;
        box-shadow: 0 8px 24px rgba(0,0,0,.06);
    }
    .info p.lead{
        margin: 8px 0 18px;
        color: var(--muted);
        line-height: 1.7;
    }
    .info-list{ display:flex; flex-direction:column; gap:16px; margin-top:10px; }
    .info-item{ display:flex; gap:12px; align-items:flex-start; }
    .info-ico{
        width:36px; height:36px; border-radius:50%;
        display:inline-flex; align-items:center; justify-content:center;
        background:#f1f1f3; color:#333; flex:0 0 36px;
        font-size:16px;
    }
    .info h5{ margin:0; font-size:16px; }
    .info small, .info a{ color:var(--muted); text-decoration:none; }
    .info a:hover{ color:var(--text); text-decoration:underline; }

    /* Form card (right) */
    .contact-card{
        background: var(--card);
        border:1px solid var(--ring);
        border-radius: 14px;
        padding: 26px 26px 30px;
        box-shadow: 0 8px 24px rgba(0,0,0,.06);
    }
    .contact-card h3{
        font-size: 26px; font-weight: 800; margin: 2px 0 16px;
    }

    label{ font-weight:700; margin: 12px 0 8px; display:block; }
    input[type="text"], input[type="email"], textarea{
        width:100%; padding: 14px 12px; border-radius:10px;
        border:1px solid var(--ring); background:var(--field);
        font-size:16px; outline:none;
        transition: box-shadow .15s ease, border-color .15s ease;
    }
    textarea{ min-height: 130px; resize: vertical; }
    input:focus, textarea:focus{
        border-color: var(--accent); box-shadow: 0 0 0 3px rgba(0,0,0,.14);
    }

    .checkbox{ display:flex; align-items:center; gap:8px; margin-top:10px; }
    .checkbox input{ width:18px; height:18px; accent-color: var(--accent); }

    .g-recaptcha{ margin-top:14px; }

    .btn-submit{
        width:100%; height:52px; border:none; border-radius:10px;
        background: var(--accent); color:#fff; font-weight:800; font-size:16px;
        display:flex; align-items:center; justify-content:center;
        margin-top:16px; cursor:pointer; text-decoration:none;
        -webkit-appearance:none; appearance:none;
        transition: background .15s ease, transform .15s ease, box-shadow .15s ease;
    }
    .btn-submit:hover{ background: var(--accent-2); transform: translateY(-1px); }
    .btn-submit:focus{ outline:none; box-shadow: 0 0 0 3px rgba(0,0,0,.2); }
</style>

<div class="contact-wrap">
    <h2 class="contact-title">Contact Us</h2>

    <div class="contact-grid">
        <!-- LEFT: info panel -->
        <aside class="info" aria-label="Contact information">
            <p class="lead">
                Whether you have questions about our services, need support, or want to share feedback,
                our team is here to help.
            </p>

            <div class="info-list">
                <div class="info-item">
                    <span class="info-ico"><i class="fa-solid fa-globe"></i></span>
                    <div>
                        <h5>Website</h5>
                        <a href="https://iconicprints.com.au" target="_blank" rel="noopener">iconicprints.com.au</a>
                    </div>
                </div>

                <div class="info-item">
                    <span class="info-ico"><i class="fa-regular fa-envelope"></i></span>
                    <div>
                        <h5>Email</h5>
                        <a href="mailto:iconicprintsofficial@gmail.com">iconicprintsofficial@gmail.com</a>
                    </div>
                </div>

                <div class="info-item">
                    <span class="info-ico"><i class="fa-solid fa-phone"></i></span>
                    <div>
                        <h5>Phone</h5>
                        <small>+61 399 499</small>
                    </div>
                </div>

                <div class="info-item">
                    <span class="info-ico"><i class="fa-solid fa-location-dot"></i></span>
                    <div>
                        <h5>Location</h5>
                        <small>
                            2 Wellington Road, Clayton<br>
                            Victoria 3800, Australia
                        </small>
                    </div>
                </div>
            </div>
        </aside>

        <!-- RIGHT: form card -->
        <section class="contact-card" aria-label="Enquiry form">
            <h3>Get in touch</h3>

            <?= $this->Form->create($contactU) ?>
            <?= $this->Form->control('full_name', [
                'label' => 'Your Name',
                'placeholder' => 'John Appleseed'
            ]) ?>

            <?= $this->Form->control('email', [
                'label' => 'Email Address',
                'placeholder' => 'name@example.com'
            ]) ?>

            <?= $this->Form->control('phone', [
                'label' => 'Phone Number',
                'placeholder' => '+61 …',
                'required' => false
            ]) ?>

            <?= $this->Form->control('body', [
                'label' => 'Message',
                'type' => 'textarea',
                'placeholder' => 'How can we help?'
            ]) ?>

            <label class="checkbox">
                <?= $this->Form->control('email_sent', ['type' => 'checkbox', 'label' => false]) ?>
                <span>Email Sent</span>
            </label>

            <!-- reCAPTCHA (uses site key from configuration) -->
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <div class="g-recaptcha" data-sitekey="<?= h(\Cake\Core\Configure::read('Recaptcha.siteKey')) ?>"></div>

            <?= $this->Form->button('SEND ENQUIRY', ['class' => 'btn-submit']) ?>
            <?= $this->Form->end() ?>
        </section>
    </div>
</div>
