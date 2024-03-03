<?= "注文番号 : " . $order->id ?><br>
<?= "依頼者のお名前 : " . $order->user->name ?><br>
<?php $total = 0; ?>
<?php foreach ($order->details as $detail): ?>
		<img src="<?= $detail->item->product->image ?>"  height="100" width="100" alt=""/>
		<?php if(($detail->item->jancode - 493000) > 0): ?>
			<?= $detail->item->product->pname ?>  
			<?= $detail->item->product->price ?> * <?= $detail->size ?> ==> 
			<?php
				$uprice = $detail->item->product->price;
				$quantity = $detail->size;
				$amount = $uprice * $quantity;
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
<?= $order->note1 ?><br>
<?= $order->note2 ?><br>
<?= $order->note3 ?><br>
