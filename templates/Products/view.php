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
            </table>
            <div class="text">
                <strong><?= __('Category') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->category)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Jancode') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->jancode)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Pname') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->pname)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Brand') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->brand)); ?>
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
        </div>
    </div>
</div>
