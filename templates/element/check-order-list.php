<div class="cart-list">
    <p><?= __('check-order-list') ?></p>
    <ul>
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
            <div  class="content-actions">
                <?= $this->Html->link(__('内容変更'), ['controller' => 'Carts', 'action' => 'editCart', $cart->id]) ?>
                <?= $this->Html->link(__('数量変更'), ['controller' => 'Carts', 'action' => 'changeSize', $cart->id]) ?>
                <?= $this->Html->link(__('Cartへ戻す'), ['controller' => 'Carts', 'action' => 'backCart', $cart->id]) ?>
                <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
            </div>
        </div>        
        <?php endforeach; ?>
    </ul>        
    <div class="pctrl">
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