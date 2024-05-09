<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Myitem $myitem
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $myitem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $myitem->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Myitems'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="myitems form content">
            <?= $this->Form->create($myitem) ?>
            <fieldset>
                <legend><?= __('Edit Myitem') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('product_id', ['options' => $products]);
                    echo $this->Form->control('jancode');
                    echo $this->Form->control('mycategory1');
                    echo $this->Form->control('mycategory2');
                    echo $this->Form->control('mycategory3');
                    echo $this->Form->control('mystore');
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
