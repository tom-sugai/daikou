<?= "注文番号 : " . $order->id ?><br>
<?= "依頼者のお名前 : " . $order->user->name ?><br>
<?= "お買物商品のリスト" ?><br>
<hr></hr>
<?php $total = 0; ?>
<?php foreach ($order->details as $detail): ?>
		<img src="<?= $detail->product->image ?>"  height="40" width="40" alt=""/>
		<?php if(($detail->product->jancode - 493000) > 0): ?>
			<?= $detail->product->pname ?>  
			<?= $detail->product->price ?> * <?= $detail->size ?> ==> 
			<?php
				$unitPrice = $detail->product->price;
				$quantity = $detail->size;
				$amount = $unitPrice * $quantity;
			?>
			<?= "金額 " . $amount . " 円" ?><br>
		<?php else: ?>
			<?= $detail->note1 ?>
			<?= $detail->note2 ?>
			<?php $amount = $detail->note3 ?>
			<?= "金額 " . $amount . " 円" ?><br>
		<?php endif; ?>
		<?php $total = $total + $amount; ?>
<?php endforeach; ?>
<hr></hr>
<?= "注文合計 " . $total . " 円" ?><br>
<?= "お届け先 " . $order->note1 ?><br>
<?= "お届け日 " . $order->note2 ?><br>
<?= "お支払い " . $order->note3 ?><br>
