<p>** echo from item_list.php ***</p>
<?php foreach($itemArray as $item): ?>
        <!-- <img src="<?= $item['image'] ?>" alt="item-img"><br/> -->
        <!-- <?= $this->Html->image($item['image'],  ['width' => 60, 'height' => 60]) . "<br/>" ?> -->
        <?= "user_id : " . $item['user_id'] . " ---- "?>
        <?= "product_id : " . $item['product_id'] . " ---- " ?>
        <?= "jancode : " . $item['jancode'] . " ---- " ?>
        <?= "store : " . $item['store'] . "<br>" ?>
<?php endforeach; ?>