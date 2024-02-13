<div class="cart-list">
    <p><?= __('fix-order-list') ?></p>
    <ul>
        <?php $total = 0; ?>
        <?php foreach ($carts as $cart): ?>
        <div class="content-list">   
            <li><?= $cart->has('item') ? $this->Html->link($cart->item->id, ['controller' => 'Items', 'action' => 'view', $cart->item->id]) : '' ?></li>
            <li><?= $this->Html->image($cart->item->product->image,  ['width' => 60, 'height' => 60]) ?></li>
            <li><?= $this->Number->format($cart->size) ?></li>
            <li><?= $this->Number->format($cart->item->product->price) ?></li>
            <?php $subtotal = $cart->size * $cart->item->product->price; ?>
            <li><?= $this->Number->format($subtotal) ?></li>
            <li class="actions">
                <!--<?= $this->Form->postLink(__('削除'), ['controller'=>'Carts', 'action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>-->
            </li>
        </div>
        <?php $total = $total + $subtotal; ?>        
        <?php endforeach; ?>
    </ul>
    <br>        
    <?= "注文合計 : " . $total . "円" ?>
</div>