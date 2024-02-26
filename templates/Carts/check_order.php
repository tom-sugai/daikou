<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Cart> $carts
 */
?>
<?php $this->set('headertext', 'headertext from element'); ?>
<div class="sheader">
    <p><?= "Info Block in the check_order.php" . " / " ?><?= "Login User : " . $username ?> </p>
    <div class="button-row">
        <?= $this->Html->link(__('商品選択へ戻る'), ['controller' => 'Items', 'action' => 'otsukai'], ['class' => 'button float-right']) ?>
        <?= $this->Html->link(__('カートへ戻る'), ['controller' => 'Carts', 'action' => 'checkCart'], ['class' => 'button float-right']) ?>
        <?= $this->Html->link(__('注文情報の入力'), ['controller' => 'Orders', 'action' => 'fixOrder'], ['class' => 'button float-right']) ?>
    </div>
</div>
<?= $this->element('check-order-list') ?>