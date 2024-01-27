<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Cart> $carts
 */
?>

<?php $this->set('headertext', 'headertext from element'); ?>
<div class="sheader">
    <p><?= "Info Block in the check_cart.php" ?></p>
    <div class="button-row">
        <?= $this->Html->link(__('商品選択へ戻る'), ['controller' => 'Items', 'action' => 'newIndex'], ['class' => 'button float-right']) ?>
        <?= $this->Html->link(__('注文商品の確認'), ['controller' => 'Carts', 'action' => 'checkOrder'], ['class' => 'button float-right']) ?>
    </div>
</div>
<div class="scontainer">   
    <?php foreach ($carts as $cart): ?>
        <div class="syohin">
            <div class="boxA">
                <?= $this->Number->format($cart->id) ?>
            </div>
            <div class="syohin-1">
                <div class="boxD"><?= $this->Html->image($cart->item->product->image,  ['width' => 60, 'height' => 60]) ?></div>
                <div class="syohin-2">
                    <div class="boxB">
                        <!--<?= $cart->item->product->category ?><?= "  ----  " ?><?= $cart->jancode ?>-->
                    </div>
                    <div class="boxE"><?= $cart->item->product->pname ?></div>
                    <div class="boxF"><?= "---- Price or Others line -----" . "<br>" ?></div>
                </div>
            </div>
            <div class="boxG">
                <?= $this->Html->link(__('注文する'), ['controller' => 'Carts', 'action' => 'order', $cart->id]) ?>
                <?= $this->Form->postLink(__('削除する'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
            </div>
            <!--<div class="boxH"><?= "---- fotter line  for each Product----890----------0---------0---------0---------0---------0" ?></div>-->    
        </div>            
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
<!--
<div class="carts index content">
    <?= $this->Html->link(__('商品選択へ戻る'), ['controller' => 'Items', 'action' => 'newIndex'], ['class' => 'button float-right']) ?>
    <?= $this->Html->link(__('注文商品の確認'), ['controller' => 'Carts', 'action' => 'checkOrder'], ['class' => 'button float-right']) ?>    
    <h3><?= __('Carts') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= "Image" ?></th>
                    <th><?= $this->Paginator->sort('item_id') ?></th>         
                    <th><?= $this->Paginator->sort('size') ?></th>
                    <th><?= $this->Paginator->sort('orderd') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carts as $cart): ?>
                <tr>
                    <td><?= $this->Number->format($cart->id) ?></td>
                    <td><?= $cart->has('user') ? $this->Html->link($cart->user_id, ['controller' => 'Users', 'action' => 'view', $cart->user_id]) : '' ?></td>
                    <td><?= $this->Html->image($cart->item->product->image,  ['width' => 60, 'height' => 60]) ?></td>
                    <td><?= $cart->has('item') ? $this->Html->link($cart->item->product->pname, ['controller' => 'Items', 'action' => 'view', $cart->item_id]) : '' ?></td>
                    <td><?= $this->Number->format($cart->size) ?></td>
                    <td><?= $cart->orderd === null ? '' : $this->Number->format($cart->orderd) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('注文する'), ['controller' => 'Carts', 'action' => 'order', $cart->id]) ?>
                        <?= $this->Form->postLink(__('削除する'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
-->
