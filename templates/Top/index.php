<?php $this->set('headertext', 'This is headertext in the Top/index.php file.'); ?>
<div class="topguid">
    <p><?= "ログインして商品選択へ進んでください" ?></p>
    <div class="button-row">
        <?= $this->Html->link(__('ログイン'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'button']) ?>
        <?= $this->Html->link(__('Go Items/index'), ['controller' => 'Items', 'action' => 'otsukai'], ['class' => 'button']) ?>
        <?= $this->Html->link(__('Go Exc/View'), ['controller' => 'ExcView', 'action' => 'index'], ['class' => 'button']) ?>
    </div>
</div>
<p style="font-size:12px;"><?= $msg ?></p>