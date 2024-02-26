<?php debug($postedData) ?>
<?php foreach ($postedData['confirmForm'] as $key => $val): ?>
    <?php if($key == 'banks'){
        foreach($postedData['confirmForm']['banks'] as $bank){
            echo "Selected Bank is : " . $bank . "<br>";
        } 
    }else {
            echo $key . " : " . $val . "<br>";
    }
    ?>
<?php endforeach; ?>