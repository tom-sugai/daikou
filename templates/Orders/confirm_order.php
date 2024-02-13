<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<?php $this->set('headertext', 'This is headertext in the new_index.ctp file.'); ?>
<div class="sheader">
    <p><?= "-- This Page is Info Block in the new_index.ctp file. --" ?></p>
    <div class="button-row">
        <?= $this->Html->link(__('商品選択へ戻る'), ['controller' => 'Items', 'action' => 'newIndex'], ['class' => 'button float-right']) ?>
    </div>
</div>
<div class="confirm-message">
    <p><?= __('ご注文の内容は以下の通りです') ?></p>
    <?= $this->element('confirm-order-list') ?>
    <p><?= "登録したメールアドレスへ確認メールを送信しました。" ?></P>
</div>