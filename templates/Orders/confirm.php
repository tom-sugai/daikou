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
<div class="scontainor"> 
    <h4><?= __('注文ありがとうございます！ ご注文の内容は以下の通りです') ?></h4>  
    <?php foreach ($order->details as $detail): ?>
        <div class="syohin">
            <div class="boxA">
                <?= $this->Number->format($detail->id) ?>
            </div>
            <div class="syohin-1">
                <div class="boxD"><?= $this->Html->image($detail->item->product->image,  ['width' => 60, 'height' => 60]) ?></div>
                <div class="syohin-2">
                    <div class="boxB">
                        <!--<?= $detail->item->product->category ?><?= "  ----  " ?><?= $detail->item->jancode ?>-->
                    </div>
                    <div class="boxE"><?= $detail->item->product->pname ?></div>
                    <div class="boxF"><?= "---- Price or Others line -----" . "<br>" ?></div>
                </div>
            </div>
            <div class="boxG">
                <!--<?= $this->Html->link(__('注文する'), ['controller' => 'Carts', 'action' => 'order', $detail->id]) ?>-->
                <!--<?= $this->Form->postLink(__('削除する'), ['action' => 'delete', $detail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $detail->id)]) ?>-->
            </div>
            <!--<div class="boxH"><?= "---- fotter line  for each Product----890----------0---------0---------0---------0---------0" ?></div>-->   
        </div>            
    <?php endforeach; ?>
    <br>
    <p><?= "登録いただいたメールアドレスへ確認メールを送信しました。ご確認ください。" ?></P>
</div>

<!--
<nav>
    <ul>
        <li class="heading"><?= __('Actions') ?></li>
        <li>    <?= $this->Html->link(__('商品選択へ戻る'), ['controller' => 'Items', 'action' => 'newIndex'], ['class' => 'button float-right']) ?> </li>
    </ul>
</nav>
<div>
    <h4><?= __('注文ありがとうございます！　ご注文の内容は以下の通りです') ?></h4>
    <?php if (!empty($order)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Order Id') ?></th>
                <th scope="col"><?= __('Product image') ?></th>
                <th scope="col"><?= __('Product Name') ?></th>
                <th scope="col"><?= __('Size') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($order->details as $detail): ?>
            <tr>
                <td><?= h($detail->id) ?></td>
                <td><?= h($detail->order_id) ?></td>
                <td><?= $this->Html->image($detail->item->product->image, array('height' => 60, 'width' => 60)) ?></td>
                <td><?= h($detail->item->product->pname) ?></td>
                <td><?= h($detail->size) ?></td>
                <td><?= h($detail->created) ?></td>
                <td><?= h($detail->modified) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
<div>
    <h3><?= "注文番号 : " . h($order->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $order->has('user') ? $this->Html->link($order->user->name, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Note1') ?></th>
            <td><?= h($order->note1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Note2') ?></th>
            <td><?= h($order->note2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order-Id') ?></th>
            <td><?= $this->Number->format($order->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($order->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($order->modified) ?></td>
        </tr>
    </table>
</div>
-->
