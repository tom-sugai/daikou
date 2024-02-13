<?php
    echo $headertext . "<br/>";
?>
<div class="o-loginlogout">
    <?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login']) ?>
    <?= " / " ?>
    <?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout']) ?>
</div>