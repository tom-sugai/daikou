<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Detail $detail
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $detail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $detail->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Details'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="details form content">
            <?= $this->Form->create($detail) ?>
            <fieldset>
                <legend><?= __('Edit Detail') ?></legend>
                <?php
                    echo $this->Form->control('order_id');
                    echo $this->Form->control('product_id', ['options' => $products]);
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
