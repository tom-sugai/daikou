<div class="items index content">
    <!--<h3><?= __('Carts') ?></h3>-->
    <div class="table-responsive">
        <table>
            <!--
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('item_id') ?></th>
                    <th><?= $this->Paginator->sort('size') ?></th>
                    <th><?= $this->Paginator->sort('orderd') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            -->
            <tbody>
                <tr>
                    <!--<td><?= $this->Number->format($cart->id) ?></td>-->
                    <!--<td><?= $cart->has('user') ? $this->Html->link($cart->user->id, ['controller' => 'Users', 'action' => 'view', $cart->user->id]) : '' ?></td>-->
                    <td><?= $cart->has('item') ? $this->Html->link($cart->item->id, ['controller' => 'Items', 'action' => 'view', $cart->item->id]) : '' ?></td>
                    <td><?= $this->Html->image($cart->item->product->image,  ['width' => 60, 'height' => 60]) ?></td>
                    <td><?= $this->Number->format($cart->size) ?></td>
                    <!--<td><?= $cart->orderd === null ? '' : $this->Number->format($cart->orderd) ?></td>-->
                    <td class="actions">
                        <!--<?= $this->Html->link(__('View'), ['action' => 'view', $cart->id]) ?>-->
                        <!--<?= $this->Html->link(__('Edit'), ['action' => 'edit', $cart->id]) ?>-->
                        <?= $this->Html->link(__('注文する'), ['action' => 'order', $cart->id]) ?>
                        <?= $this->Html->link(__('数量変更'), ['controller' => 'Carts', 'action' => 'changeSize', $cart->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>