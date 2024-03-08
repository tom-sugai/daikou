<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<?php $this->set('headertext', 'headertext from element'); ?>
<div class="sheader">
    <p><?= "-- Info Block Order/fix_order.php file. --"  . " / " ?><?= "Login User : " . $username ?> </p>
    <div class="button-row">
        <?= $this->Html->link(__('商品選択へ戻る'), ['controller' => 'Items', 'action' => 'otsukai'], ['class' => 'button float-right']) ?>
        <?= $this->Html->link(__('カートへ戻る'), ['controller' => 'Carts', 'action' => 'checkCart'], ['class' => 'button float-right']) ?>
        <?= $this->Html->link(__('注文確認へ戻る'), ['controller' => 'Carts', 'action' => 'checkOrder'], ['class' => 'button float-right']) ?>
    </div>
</div>

<?= $this->element('fix-order-list') ?>

<div class="orders form large-9 medium-8 columns content">
    <?= $this->Form->create($order) ?>
        <fieldset >
            <legend style="font-size:1.2rem;"><?= __('注文情報入力') ?></legend>
            <?= $this->Form->control('note1',['label' => ['style' => 'font-size:1.0rem']]) ?>
            <?= $this->Form->control('note2',['label' => ['style' => 'font-size:1.0rem']]) ?>
            <?= $this->Form->control('note3',['label' => ['style' => 'font-size:1.0rem']]) ?>
        </fieldset>
    <?= $this->Form->button(__('注文の確定')) ?>
    <?= $this->Form->end() ?>
</div>