<p>** This is build_product_array.php ***</p>
<?php foreach($productArray as $product): ?>
        <?= "-----------------------------------------" . "<br>" ?>
        <?= $product['jancode'] . " : "  . $product['pname'] . " : "  . $product['brand'] . " : " . $product['category'] . "<br/>" ?>
        <img src="<?= $product['image'] ?>" alt="product-img"><br/>        
        <?= $product['image'] . "<br/>"  ?>
        <?= $product['site'] . "<br/>" ?>
<?php endforeach; ?>