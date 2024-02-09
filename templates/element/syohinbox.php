<div class="items index content">
    <!--<h3><?= __('Items') ?></h3>-->
    <?php foreach ($items as $item): ?>   
        <div class="s-box-1">
            <div class="s-id"><?= $this->Number->format($item->id) ?></div>
            <div class="s-box-2">
                <div class="s-image"><?= $this->Html->image($item->product->image,  ['width' => 60, 'height' => 60]) ?></div>
                <div class="s-details">
                    <div class="s-category"><?= $item->product->category ?></div>
                    <div class="s-jancode"><?= $item->jancode ?></div>
                    <div class="s-pname"><?= $item->product->pname ?></div>
                    <div class="s-pname"><?= $item->product->price ?></div>
                    <div class="s-others"><?= "---- Others line -----" . "<br>" ?></div>
                </div>
            </div> 
            <div class="s-action">
                <?= $this->Html->link(__('カートに入れる'), ['controller' => 'Carts', 'action' => 'intoCart', $item->id]) ?>
            </div>
        </div> 
    <?php endforeach; ?> 
</div>    