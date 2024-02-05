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
        <?= $this->Html->link(__('商品選択へ戻る'), ['controller' => 'Items', 'action' => 'newIndex'], ['class' => 'button float-right']) ?>
        <?= $this->Html->link(__('カートへ戻る'), ['controller' => 'Carts', 'action' => 'checkCart'], ['class' => 'button float-right']) ?>
        <?= $this->Html->link(__('注文確認へ戻る'), ['controller' => 'Carts', 'action' => 'checkOrder'], ['class' => 'button float-right']) ?>
    </div>
</div>
<div class="scontainer">
    <?php //debug($carts); ?>
    <?php foreach ($carts as $cart): ?>
        <?php //debug($cart); ?>
        <?php $this->set('cart', $cart); ?>
        <?php $this->set('item', $cart->item); ?>
        <!-- for listview -->
        <?= $this->element('syohinlist'); ?>
        <!-- for box view
        <?= $this->element('syohinbox'); ?>
        <?= $this->element('act_fix_order'); ?>
    -->
    <?php endforeach; ?>
</div>
<div class="orders form large-9 medium-8 columns content">
    <?= $this->Form->create($order) ?>
    <fieldset>
        <legend><?= __('注文情報入力') . " 注文番号 : " . $order->id ?></legend>
        <?= $this->Form->control('note1') ?>
        <?= $this->Form->control('note2') ?>
        <?= $this->Form->control('note3') ?>
    </fieldset>
    <?= $this->Form->button(__('注文の確定')) ?>
    <?= $this->Form->end() ?>
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

<!--
<div class="carts index content">
    <?= $this->Html->link(__('商品選択へ戻る'), ['controller' => 'Items', 'action' => 'newIndex'], ['class' => 'button float-right']) ?>
    <?= $this->Html->link(__('カートへ戻る'), ['controller' => 'Carts', 'action' => 'checkCart'], ['class' => 'button float-right']) ?>
    <?= $this->Html->link(__('注文確認へ戻る'), ['controller' => 'Carts', 'action' => 'checkOrder'], ['class' => 'button float-right']) ?>
    <h3><?= __('注文の内容') ?></h3>
</div>
<div class="carts index large-9 medium-8 columns content">
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image') ?></th>
                <th scope="col"><?= $this->Paginator->sort('product_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('size') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carts as $cart): ?>
            <tr>
                <td><?= $this->Number->format($cart->id) ?></td>
                <td><?= $cart->has('user') ? $this->Html->link($cart->user->uname, ['controller' => 'Users', 'action' => 'view', $cart->user->id]) : '' ?></td>
                <td><?= $this->Html->image($cart->item->product->image, array('height' => 60, 'width' => 60)) ?></td>
                <td><?= $cart->has('product') ? $this->Html->link($cart->item->product->pname, ['controller' => 'Products', 'action' => 'view', $cart->item->product->id]) : '' ?></td>
                <td><?= $this->Number->format($cart->size) ?></td>
                <td><?= h($cart->created) ?></td>
                <td><?= h($cart->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('数量変更'), ['controller' => 'Carts', 'action' => 'changeSize', $cart->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="orders form large-9 medium-8 columns content">
    <?= $this->Form->create($order) ?>
    <fieldset>
        <legend><?= __('関連情報入力') . " 注文番号 : " . $order->id ?></legend>
        <?= $this->Form->control('note1') ?>
        <?= $this->Form->control('note2') ?>
        <?= $this->Form->control('note3') ?>
    </fieldset>
    <?= $this->Form->button(__('注文の確定')) ?>
    <?= $this->Form->end() ?>
</div>
-->