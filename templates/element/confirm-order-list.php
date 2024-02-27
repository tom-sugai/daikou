<div class="order-list">
    <p><?= __('confirm-order-list') ?></p>
    <?= "注文番号       : " . $order->id ?><br>
    <?= "依頼者のお名前 : " . $order->user->name ?><br>
    <?= "お買物商品のリスト" ?><br>
    <ul>
        <?php $total = 0; ?>
        <?php foreach ($order->details as $detail): ?>
        <div class="content-list">   
            <li><?= $detail->id ?></li>
            <li><?= $this->Html->image($detail->item->product->image,  ['width' => 60, 'height' => 60]) ?></li>
            <li><?= $this->Number->format($detail->size) ?></li>
            <li><?= $this->Number->format($detail->item->product->price) ?></li>
            <?php $subtotal = $detail->size * $detail->item->product->price; ?>
            <li><?= $this->Number->format($subtotal) ?></li>
            <?php $total = $total + $subtotal; ?>
        </div>        
        <?php endforeach; ?>
    </ul>
    <?= "注文の合計金額は " . $total . " 円です。" . "<br>" ?>
    <?= "お届け先     : " . $order->note1 . "<br>" ?> 
    <?= "お支払い方法 : " . $order->note2 . "<br>" ?> 
    <?= "お届け日時   : " . $order->note3 . "<br>" ?> 
</div>