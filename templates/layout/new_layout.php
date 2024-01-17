<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

//$cakeDescription = 'CakePHP: the rapid development php framework';
$cakeDescription = 'my_cake3';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake']) ?>
    <!-- <?= $this->Html->css('base.css') ?> -->
    <!-- <?= $this->Html->css('style.css') ?> -->
    <!-- <?= $this->Html->css('home.css') ?> -->
    <?= $this->Html->css('hbg-menu.css') ?>
    <?= $this->Html->css('new-index.css') ?>
    <?= $this->Html->css('box-test.css') ?>

    <?= $this->Html->script('jquery-3.6.0.min.js') ?>
    <?= $this->Html->script('hbg-menu.js') ?>
    
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <!-- もしすべてのビューでメニューを表示したい場合、ここに入れます -->
    <div class="topmenu">
      <p class="menubtn"><?= $this->Html->image('piece.png',['width' => 36, 'height' => 36]) ?></p>
      
      <nav>
          <ul>
              <li><a href=""><?= $this->Html->link(__('New Item'), ['action' => 'add']) ?></a></li>
              <li><a href=""><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></a></li>
              <li><a href=""><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></a></li>
          </ul>  
      </nav>
      
        <p class="ititle"><?= __('Items') ?></p>
        <p class="aboutsite"><?= $this->element('aboutsite'); ?></p>
        <p class="headerbox"><?= $this->element('headerbox'); ?></P>
      
    </div>

    <!--
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href=""><?= $this->fetch('title') ?></a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <li><a target="_blank" href="https://book.cakephp.org/3/">Documentation</a></li>
                <li><a target="_blank" href="https://api.cakephp.org/3.0/">API</a></li>
            </ul>
        </div>
    </nav>
-->
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
