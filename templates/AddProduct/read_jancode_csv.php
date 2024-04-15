<?= "3. ------------------------------" . "<br>" ?>
<?= "This is readJancodeCsv()." . "<br>" ?>
<?= $msg . " <br/>" ?>
<?= "lines : " . $lines . "<br>" ?>
<?php $i = 0; ?>
<?php foreach($data as $dataLine): ?>
        <?php $i++; ?>
        <?= "line No. : $i " . $dataLine[4] . " : " . $dataLine[5] . "<br/>" ?>
<?php endforeach; ?>