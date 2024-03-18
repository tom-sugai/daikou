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
            <?= $this->Form->control('note1',['label' => 'お届け先', 'value' => $account->address1, 'style' => ['font-size:1.2rem;']]) ?>
            <?= $this->Form->control('note2',['label' => 'お届け日', 'value' => "直近の金曜日の13:00",'style' => ['font-size:1.2rem;']]) ?>
            <?= $this->Form->control('note3',['label' => 'お支払い', 'value' => "Cogica Card", 'style' => ['font-size:1.2rem;']]) ?>
        </fieldset>
    <?= $this->Form->button(__('注文の確定')) ?>
    <?= $this->Form->end() ?>
</div>