<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Myitem> $myitems
 */
?>
<div class="myitems index content">
    <?= $this->Html->link(__('New Myitem'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Myitems') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($myitems as $myitem): ?>
                <tr>
                    <td><?= $this->Number->format($myitem->id) ?></td>
                    <td><?= $myitem->has('user') ? $this->Html->link($myitem->user->id, ['controller' => 'Users', 'action' => 'view', $myitem->user->id]) : '' ?></td>
                    <td><?= $myitem->has('product') ? $this->Html->link($myitem->product->id, ['controller' => 'Products', 'action' => 'view', $myitem->product->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $myitem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $myitem->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $myitem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $myitem->id)]) ?>
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
