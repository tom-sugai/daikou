<?= $msg . " <br/>" ?>
<?php //debug($itemJson); ?>

<p>** echo from php ***</p>
<?php foreach($itemArray as $item): ?>
        <img src="<?= $item['image'] ?>" alt="item-img"><br/>
        <?= $item['jancode'] . " : "  . $item['pname'] . " : "  . $item['brand'] . " : " . $item['category'] . "<br/>" ?>
        <?= $item['image'] . "<br/>"  ?>
        <?= $item['site'] . "<br/>" ?>
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