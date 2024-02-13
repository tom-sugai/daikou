<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
 */
?>

<?php $this->set('headertext', 'headertext from element'); ?>
<div class="sheader">
    <?= "Login User : " . $username ?>
    <p><?= "商品を選んでカートに入れてください。商品を選んだらカートの中を確認してください。" ?>
    <?= $this->Html->link(__('カートをチェック'), ['controller' => 'Carts', 'action' => 'checkCart'], ['class' => 'button10']) ?></p>
</div>
<div class="categoryform">
            <?= $this->Form->create(null, ['type' => 'post', 'url' => ['action' => 'new-index']]) ?>
            <div class="cat-in"><?= $this->Form->select('select-1', $category_list, array('empty' => '分類を選択', 'width' => 100)) ?></div>
            <div class="cat-in"><?= $this->Form->submit(__('選択')) ?></div>
            <?= $this->Form->end() ?>
</div>
<?= $this->element('item-box') ?>