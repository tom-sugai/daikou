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