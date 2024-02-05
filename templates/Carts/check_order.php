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
        <?= $this->Html->link(__('商品選択へ戻る'), ['controller' => 'Items', 'action' => 'newIndex'], ['class' => 'button10']) ?>
        <?= $this->Html->link(__('カートへ戻る'), ['controller' => 'Carts', 'action' => 'checkCart'], ['class' => 'button10']) ?>
        <?= $this->Html->link(__('注文情報の入力'), ['controller' => 'Orders', 'action' => 'fixOrder'], ['class' => 'button10']) ?>
    </div>
    <!--
    <?= $this->Html->link(__('商品選択へ戻る'), ['controller' => 'Items', 'action' => 'newIndex'], ['class' => 'button float-right']) ?>
    <?= $this->Html->link(__('カートへ戻る'), ['controller' => 'Carts', 'action' => 'checkCart'], ['class' => 'button float-right']) ?>
    <?= $this->Html->link(__('注文情報の入力'), ['controller' => 'Orders', 'action' => 'fixOrder'], ['class' => 'button float-right']) ?>
    -->
</div>
<div class="scontainer">
    <?php //debug($carts); ?>
    <?php foreach ($carts as $cart): ?>
        <?php //debug($cart); ?>
        <?php $this->set('cart', $cart); ?>
        <?php $this->set('item', $cart->item); ?>
        <?= $this->element('syohinlist'); ?>
        <!--
        <?= $this->element('syohinbox'); ?>
        <?= $this->element('act_check_order'); ?>
        -->
    <?php endforeach; ?>
</div>
<div class="pctrl">
    <ul class="pagination">
        <!--<?= $this->Paginator->first('<< ' . __('first')) ?>-->
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <!--<?= $this->Paginator->last(__('last') . ' >>') ?>-->
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
</div>