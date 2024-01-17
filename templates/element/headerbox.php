<?php
    echo $headertext . "<br/>";


    /** 
    $this->Html->addCrumb('Fumiko1','/exc-view/fumiko1');
    $this->Html->addCrumb('Fumiko2','/exc-view/fumiko2');
    $this->Html->addCrumb('Fumiko3','/exc-view/fumiko3');
    $this->Html->addCrumb('Fumiko4','/exc-view/fumiko4');
    */
?>
<?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login']) ?>
<?= " / " ?>
<?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout']) ?>
<?= " / " ?>
<?= $this->Html->link(__('Select'), ['controller' => 'Items', 'action' => 'new-index']) ?>
<?= " / " ?>
<?= $this->Html->link(__('CheckCart'), ['controller' => 'Carts', 'action' => 'check-cart']) ?>
<?= " / " ?><?= "<br>" ?>
<?= "Login User : " . $username ?>

<!--
<?= $this->Html->getCrumbs(' | ',array(
    'text' => 'top',
    'url' => '/exc-view/index',
    'escape' => false,
    )); ?>
-->