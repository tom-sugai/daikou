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
$cakeDescription = 'Otsukai';
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
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'otsukai']) ?>
    <?= $this->Html->css('hbg-menu.css') ?>
    <?= $this->Html->css('new-index.css') ?>
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
              <li><a href=""><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></a></li>
              <li><a href=""><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></a></li>
              <li><a href=""><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></a></li>
          </ul>  
      </nav>
    </div>
    <p class="ititle"><?= __('--お買物代行--お使い屋--') ?></p>
    <p class="aboutsite"><?= $this->element('aboutsite'); ?></p>
    <p class="headerbox"><?= $this->element('headerbox'); ?></P>  
    <main class="main">
        <div class="container clearfix">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
