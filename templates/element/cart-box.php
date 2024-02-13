<div class="scontainer">
    <p><?= __('check-cart Cart Box') ?></p>
    <?php foreach ($carts as $cart): ?><!-- box -->
        <div class="i-box-0">   
            <div class="i-box-1">
                <div class="i-id"><?= "Id : " . $this->Number->format($cart->item->id) . " / "?><?= " Jancode : " . $cart->item->jancode ?></div>
                <div class="i-jancode"></div>
                <div class="i-image"><?= $this->Html->image($cart->item->product->image,  ['width' => 60, 'height' => 50]) ?></div>
                <div class="i-category"><?= $cart->item->product->category ?></div>
                <div class="i-pname"><?= $cart->item->product->pname ?></div>
                <div class="i-price"><?= $cart->item->product->price . " 円 " ?></div>
                <div class="i-comment"></div>
                <div class="i-comment"><?= "---- comment line -----" . "<br>" ?></div>
            </div>
            <li class="actions">
                    <?= $this->Html->link(__('注文する'), ['action' => 'order', $cart->id]) ?>
                    <?= $this->Html->link(__('数量変更'), ['controller' => 'Carts', 'action' => 'changeSize', $cart->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
            </li>
        </div><!--end i-box-0-->
    <?php endforeach; ?>
</div> 
<div class="pctrl">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
</div>
   