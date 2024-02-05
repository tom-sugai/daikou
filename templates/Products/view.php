<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Product'), ['action' => 'edit', $product->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Product'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Product'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="products view content">
            <h3><?= h($product->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $product->has('user') ? $this->Html->link($product->user->id, ['controller' => 'Users', 'action' => 'view', $product->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($product->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $product->price === null ? '' : $this->Number->format($product->price) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Jancode') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->jancode)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Category') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->category)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Brand') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->brand)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Pname') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->pname)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Store') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->store)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Image') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->image)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Site') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->site)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Created') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->created)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Modified') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->modified)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Items') ?></h4>
                <?php if (!empty($product->items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Product Id') ?></th>
                            <th><?= __('Jancode') ?></th>
                            <th><?= __('Store') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($product->items as $items) : ?>
                        <tr>
                            <td><?= h($items->id) ?></td>
                            <td><?= h($items->user_id) ?></td>
                            <td><?= h($items->product_id) ?></td>
                            <td><?= h($items->jancode) ?></td>
                            <td><?= h($items->store) ?></td>
                            <td><?= h($items->created) ?></td>
                            <td><?= h($items->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id)]) ?>
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
