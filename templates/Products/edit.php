<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
   <aside class="column"> 
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $product->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $product->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <a href="<?= 'https://www.google.com/search?q=' . $product->jancode ?>"  target="_blank">GetInfo</a>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <!--<iframe src="https://www.janken.jp/gadgets/jan/JanSyohinKensaku.php" width="600" hight="300"></iframe> -->
        <iframe src="https://www.janken.jp/goods/jk_catalog_syosai.php?jan=<?= $product->jancode ?>"  width="800" hight="300"></iframe>
        <div class="products form content">
            <?= $this->Form->create($product) ?>
            <fieldset>
                <legend><?= __('Edit Product') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('category');
                    echo $this->Form->control('jancode');
                    echo $this->Form->control('pname');
                    echo $this->Form->control('brand');
                    echo $this->Form->control('store');
                    echo $this->Form->control('image');
                    echo $this->Form->control('site');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
