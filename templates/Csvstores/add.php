<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Csvstore $csvstore
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Csvstores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="csvstores form content">
            <?= $this->Form->create($csvstore) ?>
            <fieldset>
                <legend><?= __('Add Csvstore') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('csvname');
                    echo $this->Form->control('lineno');
                    echo $this->Form->control('codeformat');
                    echo $this->Form->control('code');
                    echo $this->Form->control('existpdb');
                    echo $this->Form->control('hitsyahoo');
                    echo $this->Form->control('mycategory1');
                    echo $this->Form->control('mycategory2');
                    echo $this->Form->control('mycategory3');
                    echo $this->Form->control('mystore');
                    echo $this->Form->control('product_id', ['options' => $products, 'empty' => true]);
                    echo $this->Form->control('category');
                    echo $this->Form->control('brand');
                    echo $this->Form->control('pname');
                    echo $this->Form->control('price');
                    echo $this->Form->control('store');
                    echo $this->Form->control('imageurl');
                    echo $this->Form->control('siteurl');
                    echo $this->Form->control('published');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
