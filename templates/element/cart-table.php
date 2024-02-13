<div class="cart-table">
    <p><?= __('check-cart Carts Table') ?></p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>item-id</th>
                    <th>image</th>
                    <th>数量</th>
                    <th>単価（円）</th>
                    <th>小計（円）</th>      
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($carts as $cart): ?>   
                    <tr>
                        <td><?= $cart->has('item') ? $this->Html->link($cart->item->id, ['controller' => 'Items', 'action' => 'view', $cart->item->id]) : '' ?></td>
                        <td><?= $this->Html->image($cart->item->product->image,  ['width' => 60, 'height' => 60]) ?></td>
                        <td><?= $this->Number->format($cart->size) ?></td>
                        <td><?= $this->Number->format($cart->item->product->price) ?></td>
                        <?php $subtotal = $cart->size * $cart->item->product->price; ?>
                        <td><?= $this->Number->format($subtotal) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('注文する'), ['action' => 'order', $cart->id]) ?>
                            <?= $this->Html->link(__('数量変更'), ['controller' => 'Carts', 'action' => 'changeSize', $cart->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
                        </td>
                    </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
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