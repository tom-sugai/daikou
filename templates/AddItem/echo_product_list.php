<?= "These jancode items are not exist in the Products table. !!" . "<br>"?>
<?= "Please enter these jancode items to the Products table !!" . "<br>"?>
<?php foreach($jancodeList2 as $jancode): ?>
        <?= $jancode . "<br/>" ?>
<?php endforeach; ?>