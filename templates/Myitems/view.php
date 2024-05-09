<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Myitem $myitem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Myitem'), ['action' => 'edit', $myitem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Myitem'), ['action' => 'delete', $myitem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $myitem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Myitems'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Myitem'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="myitems view content">
            <h3><?= h($myitem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $myitem->has('user') ? $this->Html->link($myitem->user->id, ['controller' => 'Users', 'action' => 'view', $myitem->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $myitem->has('product') ? $this->Html->link($myitem->product->id, ['controller' => 'Products', 'action' => 'view', $myitem->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($myitem->id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Jancode') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($myitem->jancode)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Mycategory1') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($myitem->mycategory1)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Mycategory2') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($myitem->mycategory2)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Mycategory3') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($myitem->mycategory3)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Mystore') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($myitem->mystore)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Note1') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($myitem->note1)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Note2') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($myitem->note2)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Note3') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($myitem->note3)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Created') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($myitem->created)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Modified') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($myitem->modified)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
