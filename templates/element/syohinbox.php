<div class="syohin">
    <div class="boxA">
        <?= $this->Number->format($item->id) ?>
    </div>
    <div class="syohin-1">
        <div class="boxD"><?= $this->Html->image($item->product->image,  ['width' => 60, 'height' => 60]) ?></div>
        <div class="syohin-2">
            <div class="boxB">
                <?= $item->product->category ?><?= "  ----  " ?><?= $item->jancode ?>
            </div>
            <div class="boxE"><?= $item->product->pname ?></div>
            <div class="boxF"><?= "---- Price or Others line -----" . "<br>" ?></div>
        </div>
    </div>
    <div class="boxG">
            <?= $this->Html->link(__('カートに入れる'), ['controller' => 'Carts', 'action' => 'intoCart', $item->id]) ?>
            <!--
            <?= $this->Html->link(__('View'), ['action' => 'view', $item->id]) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $item->id]) ?>
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?>
            -->
    </div>
    <div class="boxH"><?= "---- fotter line  for each Product----" ?></div>   
</div>            