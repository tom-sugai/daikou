<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Server Get Sample</title>
    <!--
    <link rel="stylesheet" href="../css2/normalize.min.css">
    <link rel="stylesheet" href="../css2/milligram.min.css">
    <link rel="stylesheet" href="../css2/cake.css">
    -->
    <link rel="stylesheet" href="../css2/fonts.css">
    <link rel="stylesheet" href="../css2/pure-html-css.css">
    
</head>
<body> 
    <?php
        $str = $_POST['text-1'];
        echo "Your input is " . $str . "<br>";
        $telno = $_POST['telno'];
        echo "Your telno is " . $telno . "<br>";
        $email = $_POST['email'];
        echo "Your Email is " . $email . "<br>";

        $dt = $_POST['date'];
        echo "Today is " . $dt . "<br>";
        $time = $_POST['time'];
        echo "Now time is " . $time . "<br>";

        $message = $_POST['textarea'];
        echo "Your message is " . "\"" . $message . "\"" . "<br>";

        if($_POST['check-1'])
        { $red = "yes";} else { $red = "no";}
        echo "like red ? " . $red . "<br>";

        if($_POST['check-2'])
        { $blue = "yes";} else { $blue = "no";}
        echo "like blue ? " . $blue . "<br>";        

        echo "choice-1 : " . $_POST['anser'] . "<br>";
        echo "choice-2 : " . $_POST['account'] . "<br>";

        if($_POST['select-1']){
            $banks = $_POST['select-1'];  // $bank is array which allow for mulitiple select
            foreach($banks as $bank){
                echo "selected bank code : " . $bank . "<br>"; 
            }    
        } else {
            echo "Please select bank!!" . "<br";
        }
    ?>
</body>
</html>