<?php
/**
 * @var \App\View\AppView $this
 * @var array $lists
 */
$this->assign('title', 'My lists');
$lists = $lists ?? [

];
?>
<style>
    :root{--bg:#f6f7fb;--card:#fff;--ring:#e9e9ee;--muted:#6b7280;--text:#111827;--primary:#000;--primary-2:#222}
    .page{background:var(--bg);padding:24px 16px 48px}
    .wrap{max-width:1100px;margin:0 auto}
    .card{background:var(--card);border:1px solid var(--ring);border-radius:14px;box-shadow:0 10px 28px rgba(0,0,0,.06);overflow:hidden}
    .hd{padding:20px;border-bottom:1px solid var(--ring);display:flex;justify-content:space-between;align-items:center}
    .hd h2{margin:0;font-weight:900;color:var(--text);font-size:22px}
    .body{padding:20px}
    .form{border:1px dashed var(--ring);border-radius:12px;padding:14px;background:#fff}
    label{display:block;margin-bottom:6px;font-weight:800;color:var(--text)}
    input{width:100%;padding:12px;border:1px solid var(--ring);border-radius:10px}
    .actions{margin-top:12px;display:flex;gap:10px}
    .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:16px}
    @media(max-width:1000px){.grid{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:700px){.grid{grid-template-columns:1fr}}
    .tile{border:1px solid var(--ring);border-radius:12px;padding:14px;background:#fff}
    .tile h3{margin:0 0 6px;font-size:16px}
    .muted{color:var(--muted)}

    .acc-btn{display:inline-flex;gap:6px;align-items:center;padding:10px 14px;border:1px solid var(--ring);border-radius:10px;background:#fff;
        text-decoration:none;color:var(--text);font-weight:800;cursor:pointer}
    .acc-btn:hover{background:#fafafa}
    .acc-btn-primary{background:var(--primary);border-color:var(--primary);color:#fff}
    .acc-btn-primary:hover{background:var(--primary-2)}
</style>

<div class="page">
    <div class="wrap">
        <div class="card">
            <div class="hd">
                <h2>My lists</h2>
                <?= $this->Html->link('← Back to Account',['action'=>'dashboard'],['class'=>'acc-btn']) ?>
            </div>
            <div class="body">
                <div class="form">
                    <label>Create new list</label>
                    <?= $this->Form->create(null,['url'=>['action'=>'lists']]) ?>
                    <?= $this->Form->control('name',['label'=>false,'placeholder'=>'e.g. Favourite prints']) ?>
                    <div class="actions">
                        <?= $this->Form->button('Create',['class'=>'acc-btn acc-btn-primary']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                    <div class="muted" style="margin-top:6px">Use lists to quickly reorder your frequent products.</div>
                </div>

                <?php if (!empty($lists)): ?>
                    <div class="grid">
                        <?php foreach ($lists as $l): ?>
                            <div class="tile">
                                <h3><?= h($l['name'] ?? 'Unnamed list') ?></h3>
                                <div class="muted"><?= (int)($l['items_count'] ?? 0) ?> items</div>
                                <div class="actions" style="margin-top:8px">
                                    <?= $this->Html->link('Open',['controller'=>'Lists','action'=>'view',$l['id']],['class'=>'acc-btn']) ?>
                                    <?= $this->Html->link('Rename',['controller'=>'Lists','action'=>'edit',$l['id']],['class'=>'acc-btn']) ?>
                                    <?= $this->Form->postLink('Delete',['controller'=>'Lists','action'=>'delete',$l['id']],[
                                        'confirm'=>'Delete this list?','class'=>'acc-btn'
                                    ]) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="muted" style="margin-top:10px">You don’t have any lists yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
