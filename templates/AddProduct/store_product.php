<?= "This is storeProduct method." . " <br/>" ?>
<?php //debug($productArray); ?>
<?php foreach($productArray as $element): ?>
        <img src="<?= $element['image'] ?>" alt="item-img"><br/>
        <?= $element['jancode'] . " : "  . $element['pname'] . " : "  . $element['brand'] . " : " . $element['category'] . "<br/>" ?>
        <?= $element['image'] . "<br/>"  ?>
        <?= $element['site'] . "<br/>" ?>
<?php endforeach; ?>