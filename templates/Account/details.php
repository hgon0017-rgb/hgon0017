<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Edit details');
?>
<style>
    :root{--bg:#f6f7fb;--card:#fff;--ring:#e9e9ee;--muted:#6b7280;--text:#111827;--primary:#000;--primary-2:#222}
    .page{background:var(--bg);padding:24px 16px 48px}
    .wrap{max-width:900px;margin:0 auto}
    .card{background:var(--card);border:1px solid var(--ring);border-radius:14px;box-shadow:0 10px 28px rgba(0,0,0,.06);overflow:hidden}
    .hd{padding:20px;border-bottom:1px solid var(--ring);display:flex;justify-content:space-between;align-items:center}
    .hd h2{margin:0;font-weight:900;color:var(--text);font-size:22px}
    .body{padding:20px}
    .grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    @media(max-width:800px){.grid{grid-template-columns:1fr}}
    label{display:block;margin-bottom:6px;font-weight:800;color:var(--text)}
    input,select{width:100%;padding:12px;border:1px solid var(--ring);border-radius:10px;outline:none;background:#fff}
    input:focus,select:focus{box-shadow:0 0 0 3px rgba(0,0,0,.12);border-color:#c9cbd2}
    .help{font-size:12px;color:var(--muted);margin-top:6px}
    .actions{margin-top:18px;display:flex;gap:10px}

    .acc-btn{display:inline-flex;gap:6px;align-items:center;padding:10px 14px;border:1px solid var(--ring);border-radius:10px;background:#fff;
        text-decoration:none;color:var(--text);font-weight:800;cursor:pointer}
    .acc-btn:hover{background:#fafafa}
    .acc-btn-primary{background:var(--primary);border-color:var(--primary);color:#fff}
    .acc-btn-primary:hover{background:var(--primary-2)}
    .pwrel{position:relative}
    .toggle{position:absolute;right:10px;top:50%;transform:translateY(-50%);border:0;background:transparent;color:var(--muted);cursor:pointer;font-weight:800}
    .toggle:hover{color:#111}
</style>

<div class="page">
    <div class="wrap">
        <div class="card">
            <div class="hd">
                <h2>Edit details</h2>
                <?= $this->Html->link('← Back to Account', ['action'=>'dashboard'], ['class'=>'acc-btn']) ?>
            </div>
            <div class="body">
                <?= $this->Form->create($user, ['url'=>['action'=>'details']]) ?>
                <div class="grid">
                    <div>
                        <label>Email</label>
                        <?= $this->Form->control('email',['label'=>false,'type'=>'email','required'=>true]) ?>
                        <div class="help">We’ll never share your email.</div>
                    </div>

                    <div class="pwrel">
                        <label>Password (optional)</label>
                        <?= $this->Form->control('password',['label'=>false,'type'=>'password','value'=>'','id'=>'pwd']) ?>
                        <button type="button" class="toggle" id="togglePwd">SHOW</button>
                        <div class="help">Leave blank to keep current password.</div>
                    </div>



                <div class="actions">
                    <?= $this->Form->button('Save changes',['class'=>'acc-btn acc-btn-primary']) ?>
                    <?= $this->Html->link('Cancel',['action'=>'dashboard'],['class'=>'acc-btn']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<script>
    (function(){
        const btn=document.getElementById('togglePwd');
        const ipt=document.getElementById('pwd');
        if(btn && ipt){
            btn.addEventListener('click',()=>{
                const show=ipt.getAttribute('type')==='password';
                ipt.setAttribute('type',show?'text':'password');
                btn.textContent=show?'HIDE':'SHOW';
            });
        }
    })();
</script>
