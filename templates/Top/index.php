<?php $this->set('headertext', 'This is headertext in the Top/index.php file.'); ?>
<div class="topguid">
    <p><?= "ログインして商品選択へ進んでください" ?></p>
    <div class="button-row">
        <?= $this->Html->link(__('商品の選択'), ['controller' => 'Items', 'action' => 'otsukai'], ['class' => 'button']) ?>
        <?= $this->Html->link(__('商品の登録'), ['controller' => 'AddItem', 'action' => 'setCsvListClientList'], ['class' => 'button']) ?>
    </div>
</div>
<p style="font-size:12px;"><?= $msg ?></p>