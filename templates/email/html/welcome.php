<?= $order->id ?><br>
<?= $order->user->username ?><br>
<?php $total = 0; ?>
<?php foreach ($order->details as $detail): ?>
		<img src="<?= $detail->item->product->image ?>"  height="100" width="100" alt=""/>
		<?= $detail->item->product->pname ?>  
        <?= $detail->item->product->price ?> * <?= $detail->size ?> ==> 
        <?php
		    $uprice = $order->details[0]->item->product->price;
		    $quantity = $order->details[0]->size;
		    $amount = $uprice * $quantity;
            $total = $total + $amount; 
		 ?>
		<?= "金額 " . $amount . " 円" ?><br>
<?php endforeach; ?>
<hr></hr>
<?= "注文合計 " . $total . " 円" ?><br>
<?= $order->note1 ?><br>
<?= $order->note2 ?><br>
<?= $order->note3 ?><br>
