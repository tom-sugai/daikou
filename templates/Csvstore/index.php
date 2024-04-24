<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Csvstore> $csvstore
 */
?>
<div class="csvstore index content">
    <?= $this->Html->link(__('New Csvstore'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Csvstore') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('lineno') ?></th>
                    <th><?= $this->Paginator->sort('existpdb') ?></th>
                    <th><?= $this->Paginator->sort('hitsyahoo') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($csvstore as $csvstore): ?>
                <tr>
                    <td><?= $this->Number->format($csvstore->id) ?></td>
                    <td><?= $csvstore->has('user') ? $this->Html->link($csvstore->user->id, ['controller' => 'Users', 'action' => 'view', $csvstore->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($csvstore->lineno) ?></td>                    
                    <td><?= $csvstore->existpdb === null ? '' : $this->Number->format($csvstore->existpdb) ?></td>
                    <td><?= $csvstore->hitsyahoo === null ? '' : $this->Number->format($csvstore->hitsyahoo) ?></td>
                    <td><?= $csvstore->has('product') ? $this->Html->link($csvstore->product->id, ['controller' => 'Products', 'action' => 'view', $csvstore->product->id]) : '' ?></td>
                    <td><?= $csvstore->price === null ? '' : $this->Number->format($csvstore->price) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $csvstore->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $csvstore->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $csvstore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $csvstore->id)]) ?>
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
