<div class="cart-list">
    <p><?= __('fix-order-list') ?></p>
    <ul>
        <?php $total = 0; ?>
        <?php foreach ($carts as $cart): ?>
            <div class="content-list">
            <div class="base-info">   
                <li><?= $cart->has('product') ? $this->Html->link($cart->product->id, ['controller' => 'Products', 'action' => 'view', $cart->product->id]) : '' ?></li>
                <li><?= $this->Html->image($cart->product->image,  ['width' => 60, 'height' => 60]) ?></li>
            </div>
            <div class="side-box">                
                <div class="name-price">
                    <?= $cart->product->pname ?>
                    <?= $this->Number->format($cart->size) ?>
                    <?= $this->Number->format($cart->product->price) ?>
                    <?php $subtotal = $cart->size * $cart->product->price; ?>
                    <?= $this->Number->format($subtotal) ?>
                </div>
                <div class="add-info">
                    <?= $cart->note1 ?>
                    <?= $cart->note2 ?>
                    <?= $cart->note3 ?>
                </div>
            </div>
        <?php
            if($cart->note3 == null ){$cart->note3 = 0;} 
            $total = $total + $subtotal + $cart->note3; 
        ?>
        <div  class="content-actions">
                <?= $this->Html->link(__('内容変更'), ['controller' => 'Carts', 'action' => 'editCart', $cart->id]) ?>
                <?= $this->Html->link(__('数量変更'), ['controller' => 'Carts', 'action' => 'changeSize', $cart->id]) ?>
                <?= $this->Html->link(__('Cartへ戻す'), ['controller' => 'Carts', 'action' => 'backCart', $cart->id]) ?>
                <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
            </div>        
        <?php endforeach; ?>
    </ul>
    <br>        
    <?= "注文合計 : " . $total . "円" ?>
</div>