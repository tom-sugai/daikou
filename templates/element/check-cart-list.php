<div class="cart-list">
    <p><?= __('check-cart List') ?></p>
    <ul>
        <?php foreach ($carts as $cart): ?>
        <div class="content-list">   
            <li><?= $cart->has('item') ? $this->Html->link($cart->item->id, ['controller' => 'Items', 'action' => 'view', $cart->item->id]) : '' ?></li>
            <li><?= $this->Html->image($cart->item->product->image,  ['width' => 60, 'height' => 60]) ?></li>
            <li><?= $this->Number->format($cart->size) ?></li>
            <li><?= $this->Number->format($cart->item->product->price) ?></li>
            <?php $subtotal = $cart->size * $cart->item->product->price; ?>
            <li><?= $this->Number->format($subtotal) ?></li>
            <li class="actions">
                <?= $this->Html->link(__('注文する'), ['action' => 'order', $cart->id]) ?>
                <!--<?= $this->Html->link(__('数量変更'), ['controller' => 'Carts', 'action' => 'changeSize', $cart->id]) ?>-->
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
            </li>
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