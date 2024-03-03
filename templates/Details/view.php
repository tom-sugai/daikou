<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Detail $detail
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Detail'), ['action' => 'edit', $detail->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Detail'), ['action' => 'delete', $detail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $detail->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Details'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Detail'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="details view content">
            <h3><?= h($detail->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Item') ?></th>
                    <td><?= $detail->has('item') ? $this->Html->link($detail->item->id, ['controller' => 'Items', 'action' => 'view', $detail->item->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($detail->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Order Id') ?></th>
                    <td><?= $this->Number->format($detail->order_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Size') ?></th>
                    <td><?= $this->Number->format($detail->size) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Note1') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($detail->note1)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Note2') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($detail->note2)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Note3') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($detail->note3)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Created') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($detail->created)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Modified') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($detail->modified)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Orders') ?></h4>
                <?php if (!empty($detail->orders)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Detail Id') ?></th>
                            <th><?= __('Note1') ?></th>
                            <th><?= __('Note2') ?></th>
                            <th><?= __('Note3') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($detail->orders as $orders) : ?>
                        <tr>
                            <td><?= h($orders->id) ?></td>
                            <td><?= h($orders->user_id) ?></td>
                            <td><?= h($orders->detail_id) ?></td>
                            <td><?= h($orders->note1) ?></td>
                            <td><?= h($orders->note2) ?></td>
                            <td><?= h($orders->note3) ?></td>
                            <td><?= h($orders->created) ?></td>
                            <td><?= h($orders->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $orders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $orders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orders', 'action' => 'delete', $orders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orders->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
