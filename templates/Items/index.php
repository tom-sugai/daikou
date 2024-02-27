<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Item> $items
 */
?>
<div class="items index content">
    <?= $this->Html->link(__('Back to Top'), ['controller' => 'Top', 'action' => 'index'], ['class' => 'button float-right']) ?>
    <h4><?= __('Items') ?></h4>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <!--<th><?= $this->Paginator->sort('product_id') ?></th>-->
                    <th><?= "Store" ?></th>
                    <th><?= "Image" ?></th>
                    <th><?= "Product Name" ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $this->Number->format($item->id) ?></td>
                    <td><?= $item->has('user') ? $this->Html->link($item->user->name, ['controller' => 'Users', 'action' => 'view', $item->user->id]) : '' ?></td>
                    <td><?= $item->store ?></td>
                    <td><?= $this->Html->image($item->product->image,  ['width' => 60, 'height' => 60]) ?></td>
                    <td><?= $item->has('product') ? $this->Html->link($item->product->pname, ['controller' => 'Products', 'action' => 'view', $item->product->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $item->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $item->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?>
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
