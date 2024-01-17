<!-- <h4><?= $msg; ?></h4> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title><?= h($this->fetch('title')) ?></title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- 外部ファイルとスクリプトファイルがここに入ります (詳しくは HTML ヘルパーを参照。) -->
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('style-1') ?>
    <?= $this->Html->css('style-2') ?>

    <!-- <?= $this->Html->script('jquery-3.6.0.min.js') ?> -->
    <!-- <?= $this->Html->script('hbg-menu.js') ?> -->
    <?= $this->Html->script('prototype-1.6.1.js') ?>
    <?= $this->Html->script('textmessagechange.js') ?>
    <?= $this->Html->script('testajax.js') ?>

    <?php
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>

    <?php $this->set('headertext', '----- header block'); ?>
    <?php $this->set('footertext', '----- footer block'); ?>
</head>
<body>
    <!-- 表示するページのヘッダーを追加する -->
    <!-- <div id="header"><?= $this->element('headerbox'); ?></div> -->
    <h2><?= $msg ?></h2>
    <?php debug($json_array); ?>
    <!-- ここがビューで表示されるようにしたい場所です -->
    <script type="text/JavaScript">
        const array = <?php echo $json_array; ?>;
        document.write(array.a.toString() + " : " + array.b.toString() + " : "  + array.c.toString());
        console.log({array});
    </script>
    <br/><br/>
    <div id="divbox">
    <span>初期のテキスト</span>
    </div>
    <br/>
    <input type="button" onclick="textmessagechange();" value="メッセージの変更">
    <br/><br/>
    <input type="button" onclick="testajax();" value="testAjax">

    <!-- 表示される各ページにフッターを追加します -->
    <!-- <div id="footer"><?= $this->element('footerbox'); ?></div> -->
</body>
</html>