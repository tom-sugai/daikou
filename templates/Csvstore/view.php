<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Csvstore $csvstore
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Csvstore'), ['action' => 'edit', $csvstore->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Csvstore'), ['action' => 'delete', $csvstore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $csvstore->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Csvstore'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Csvstore'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="csvstore view content">
            <h3><?= h($csvstore->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $csvstore->has('user') ? $this->Html->link($csvstore->user->id, ['controller' => 'Users', 'action' => 'view', $csvstore->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $csvstore->has('product') ? $this->Html->link($csvstore->product->id, ['controller' => 'Products', 'action' => 'view', $csvstore->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($csvstore->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lineno') ?></th>
                    <td><?= $this->Number->format($csvstore->lineno) ?></td>
                </tr>
                <tr>
                    <th><?= __('Existpdb') ?></th>
                    <td><?= $csvstore->existpdb === null ? '' : $this->Number->format($csvstore->existpdb) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hitsyahoo') ?></th>
                    <td><?= $csvstore->hitsyahoo === null ? '' : $this->Number->format($csvstore->hitsyahoo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $csvstore->price === null ? '' : $this->Number->format($csvstore->price) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Csvname') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->csvname)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Codeformat') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->codeformat)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Code') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->code)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Mycategory1') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->mycategory1)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Mycategory2') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->mycategory2)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Mycategory3') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->mycategory3)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Mystore') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->mystore)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Category') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->category)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Brand') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->brand)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Pname') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->pname)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Store') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->store)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Imageurl') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->imageurl)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Siteurl') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($csvstore->siteurl)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
