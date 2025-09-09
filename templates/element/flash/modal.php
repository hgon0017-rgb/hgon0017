<?php if (!empty($message)): ?>
    <div class="ip-modal" role="dialog" aria-modal="true" aria-labelledby="ip-modal-title" style="display:block">
        <div class="ip-modal__backdrop"></div>
        <div class="ip-modal__dialog" role="document" tabindex="-1">
            <button type="button" class="ip-modal__x" aria-label="Close">×</button>
            <h3 id="ip-modal-title" class="ip-modal__title">Confirm</h3>
            <p class="ip-modal__body"><?= h($message) ?></p>
            <div class="ip-modal__footer">
                <button type="button" class="ip-modal__btn ip-modal__btn--primary">OK</button>
            </div>
        </div>
    </div>

    <style>
        .ip-modal{position:fixed;inset:0;z-index:9999}
        .ip-modal__backdrop{position:absolute;inset:0;background:rgba(0,0,0,.55)}
        .ip-modal__dialog{position:relative;width:92%;max-width:420px;margin:14vh auto 0;background:#fff;border-radius:12px;box-shadow:0 14px 40px rgba(0,0,0,.3);padding:20px 22px 16px;outline:none}
        .ip-modal__x{position:absolute;top:8px;right:10px;border:0;background:transparent;font-size:22px;line-height:1;cursor:pointer;color:#666}
        .ip-modal__title{margin:0 0 8px;font-weight:700;font-size:18px;color:#222}
        .ip-modal__body{margin:0 0 16px}
        .ip-modal__footer{display:flex;gap:10px;justify-content:flex-end}
        .ip-modal__btn{border:0;padding:9px 14px;border-radius:8px;cursor:pointer;font-weight:600}
        .ip-modal__btn--primary{background:#111;color:#fff}
    </style>

    <script>
        (function(){
            var root=document.querySelector('.ip-modal'); if(!root) return;
            function close(){ root.style.display='none'; }
            root.querySelector('.ip-modal__backdrop')?.addEventListener('click', close);
            root.querySelector('.ip-modal__x')?.addEventListener('click', close);
            root.querySelector('.ip-modal__btn--primary')?.addEventListener('click', close);
        })();
    </script>
<?php endif; ?>

