<?php $this->set('headertext', 'This is headertext in the Top/index.php file.'); ?>

<div class="topguid">
    <p><?= "ログインして商品選択へ進んでください" ?></p>
    <div class="button-row">
        <?= $this->Html->link(__('ログイン'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'button']) ?>
    </div>
</div>

<?= $msg ?>