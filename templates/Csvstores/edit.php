<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Csvstore $csvstore
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
                ['action' => 'delete', $csvstore->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $csvstore->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Csvstores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <a href="<?= 'https://www.google.com/search?q=' . $csvstore->code ?>"  target="_blank">GetInfo</a>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <iframe src="https://www.janken.jp/goods/jk_catalog_syosai.php?jan=<?= $csvstore->code ?>"  width="800" hight="300"></iframe>
        <div class="csvstores form content">
            <?= $this->Form->create($csvstore) ?>
            <fieldset>
                <legend><?= __('Edit Csvstore') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('csvname');
                    echo $this->Form->control('lineno');
                    echo $this->Form->control('codeformat');
                    echo $this->Form->control('code');
                    echo $this->Form->control('existpdb');
                    echo $this->Form->control('hitsyahoo');
                    echo $this->Form->select('mycategory1', $mycategory1_list, array('empty' => '大分類を選択', 'width' => 40));
                    echo $this->Form->select('mycategory2', $mycategory2_list, array('empty' => '中分類を選択', 'width' => 40));
                    echo $this->Form->select('mycategory3', $mycategory3_list, array('empty' => '小分類を選択', 'width' => 40));
                    echo $this->Form->control('mystore');
                    echo $this->Form->control('product_id', ['options' => $products, 'empty' => true]);
                    echo $this->Form->control('category');
                    echo $this->Form->control('brand');
                    echo $this->Form->control('pname');
                    echo $this->Form->control('price');
                    echo $this->Form->control('store');
                    echo $this->Form->control('imageurl');
                    echo $this->Form->control('siteurl');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
