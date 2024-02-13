<div class="item-list">
    <p><?= __('new-index Item List') ?></p>
    <ul>
        <?php foreach ($items as $item): ?>
        <div class="list-content">   
            <li><?= "Id : " . $this->Number->format($item->id) . " / "?><?= " Jancode : " . $item->jancode ?></li>
            <li><?= $this->Html->image($item->product->image,  ['width' => 60, 'height' => 50]) ?></li>
            <li><?= $item->product->category ?></li>
            <li><?= $item->product->pname ?></li>
            <li><?= $item->product->price . " 円 " ?></li>
            <li><?= "---- comment line -----" . "<br>" ?></li>
            <div class="actions">
            <li><?= $this->Html->link(__('カートに入れる'), ['controller' => 'Carts', 'action' => 'intoCart', $item->id]) ?></li>
            </div>
        </div>        
        <?php endforeach; ?>
    </ul>        
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
</div>