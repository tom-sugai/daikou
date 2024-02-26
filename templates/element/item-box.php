<p><?= __('otsukai Item Box') ?></p>
<div class="scontainer">
    <?php foreach ($items as $item): ?><!-- box -->
        <div class="i-box-0">   
            <div class="i-box-1">
                <div class="i-id"><?= "Id : " . $this->Number->format($item->id) . " / "?><?= " Jancode : " . $item->jancode ?></div>
                <div class="i-image"><?= $this->Html->image($item->product->image,  ['width' => 60, 'height' => 50]) ?></div>
                <div class="i-category"><?= $item->product->category ?></div>
                <div class="i-pname"><?= $item->product->pname ?></div>
                <div class="i-price"><?= $item->product->price . " 円 " ?></div>
            </div>
            <div class="i-box-2">
                <div class="i-comment"><?= "---- comment line -----" ?></div>
                <div class="i-action"><?= $this->Html->link(__('カートに入れる'), ['controller' => 'Carts', 'action' => 'intoCart', $item->id], ['class' => 'button float-right']) ?></div>
            </div>
        </div><!--end s-box-0-->
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