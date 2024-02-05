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
<div class="scontainer">
    <!--<h3><?= __('Items') ?></h3>-->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <!--<th><?= $this->Paginator->sort('id') ?></th>-->
                    <!--<th><?= $this->Paginator->sort('user_id') ?></th>-->
                    <!--<th><?= $this->Paginator->sort('product_id') ?></th>-->
                    <!--<th class="actions"><?= __('Actions') ?></th>-->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($items as $item): ?>
                        <?php $this->set('item', $item); ?>
                        <?= $this->element('itemlist'); ?>
                        <!--
                        <?= $this->element('syohinbox'); ?>
                        <?= $this->element('act_new_index'); ?>
                        -->
                    <?php endforeach; ?>

                </tr>
            </tbody>
        </table>
    </div>
</div>
                    </div>  
<div class="pctrl">
    <ul class="pagination">
        <!--<?= $this->Paginator->first('<< ' . __('first')) ?>-->
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <!--<?= $this->Paginator->last(__('last') . ' >>') ?>-->
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
</div>


