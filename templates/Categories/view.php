<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="categories view content">
            <h3><?= h($category->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($category->id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Category1') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($category->category1)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Category2') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($category->category2)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Category3') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($category->category3)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
