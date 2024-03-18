<div class="order-list">
    <p><?= __('confirm-order-list') ?></p>
    <?= "注文番号       : " . $order->id ?><br>
    <?= "依頼者のお名前 : " . $order->user->name ?><br>
    <?= "お買物商品のリスト" ?><br>
    <ul>
        <?php $total = 0; ?>
        <?php foreach ($details as $detail): ?>
            <div class="content-list">
            <div class="base-info">   
                <li><?= $this->Html->link($detail->product->id, ['controller' => 'Items', 'action' => 'view', $detail->product->id]) ?></li>
                <li><?= $this->Html->image($detail->product->image,  ['width' => 60, 'height' => 60]) ?></li>
            </div>
            <div class="side-box">                
                <div class="name-price">
                    <?= $detail->product->pname ?>
                    <?= $this->Number->format($detail->size) ?>
                    <?= $this->Number->format($detail->product->price) ?>
                    <?php $subtotal = $detail->size * $detail->product->price; ?>
                    <?= $this->Number->format($subtotal) ?>
                </div>
                <div class="add-info">
                    <?= $detail->note1 ?>
                    <?= $detail->note2 ?>
                    <?= $detail->note3 ?>
                </div>
            </div>
        <?php $total = $total + $subtotal + $detail->note3; ?> 
        <?php endforeach; ?>
    </ul>
    <?= "注文の合計金額は " . $total . " 円です。" . "<br>" ?>
    <?= "お届け先     : " . $order->note1 . "<br>" ?> 
    <?= "お支払い方法 : " . $order->note2 . "<br>" ?> 
    <?= "お届け日時   : " . $order->note3 . "<br>" ?> 
</div>