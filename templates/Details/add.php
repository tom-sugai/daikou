<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Detail $detail
 * @var \Cake\Collection\CollectionInterface|string[] $items
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Details'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="details form content">
            <?= $this->Form->create($detail) ?>
            <fieldset>
                <legend><?= __('Add Detail') ?></legend>
                <?php
                    echo $this->Form->control('order_id');
                    echo $this->Form->control('item_id', ['options' => $items]);
                    echo $this->Form->control('size');
                    echo $this->Form->control('note1');
                    echo $this->Form->control('note2');
                    echo $this->Form->control('note3');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
