<?= $msg . " <br/>" ?>
<?php foreach($productArray as $product): ?>
        <img src="<?= $product['image'] ?>" alt="item-img"><br/>
        <?= $product['jancode'] . " : "  . $product['pname'] . " : "  . $product['brand'] . " : " . $product['category'] . "<br/>" ?>
        <?= $product['image'] . "<br/>"  ?>
        <?= $product['site'] . "<br/>" ?>
<?php endforeach; ?>

<!--
<p>** echo fron JavaScript **</p>
<script type="text/JavaScript">
        const array = <?php echo $itemJson; ?>;
        console.log({array});
        //document.write(array[0].itemImage + "<br/>");
        document.write("<img src='" + array[0].itemImage + "' alt='item_img'>" + "<br/>");
        document.write(array[0].janCode + "<br/>");
        document.write(array[0].name + "<br/>");
        document.write(array[0].brand + "<br/>");
        document.write(array[0].category + "<br/>");
        document.write(array[0].itemUrl + "<br/>");
</script>
-->