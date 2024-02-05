<!--<?= $this->Number->format($detail->id) ?>-->
<!--<?= $detail->has('user') ? $this->Html->link($detail->user->id, ['controller' => 'Users', 'action' => 'view', $detail->user->id]) : '' ?>-->
<?= $detail->has('item') ? $this->Html->link($detail->item->id, ['controller' => 'Items', 'action' => 'view', $detail->item->id]) : '' ?>
<?= $this->Html->image($detail->item->product->image,  ['width' => 60, 'height' => 60]) ?>
<?= $detail->item->product->pname ?>
<?= "注文数 : " . $this->Number->format($detail->size) ?>
<!--<?= $detail->orderd === null ? '' : $this->Number->format($detail->orderd) ?>-->
<br>

                    <!--
<div class="items index content">
    <h3><?= __('Detail') ?></h3>
    <div class="table-responsive">
        <table>
            
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
            
            <tbody>
                <?php foreach ($details as $detail): ?>
                <tr>
                    <td><?= $this->Number->format($detail->id) ?></td>
                    <td><?= $detail->has('user') ? $this->Html->link($detail->user->id, ['controller' => 'Users', 'action' => 'view', $detail->user->id]) : '' ?></td>
                    <td><?= $detail->has('item') ? $this->Html->link($detail->item->id, ['controller' => 'Items', 'action' => 'view', $detail->item->id]) : '' ?></td>
                    <td><?= $this->Html->image($detail->item->product->image,  ['width' => 60, 'height' => 60]) ?></td>
                    <td><?= $this->Number->format($detail->size) ?></td>
                    <td><?= $detail->orderd === null ? '' : $this->Number->format($detail->orderd) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $detail->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $detail->id]) ?>
                        <?= $this->Html->link(__('注文する'), ['action' => 'order', $detail->id]) ?>
                        <?= $this->Html->link(__('数量変更'), ['controller' => 'Carts', 'action' => 'changeSize', $detail->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $detail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $detail->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
-->
