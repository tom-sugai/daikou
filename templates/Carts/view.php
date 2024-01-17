<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cart $cart
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Cart'), ['action' => 'edit', $cart->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cart'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Carts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cart'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="carts view content">
            <h3><?= h($cart->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $cart->has('user') ? $this->Html->link($cart->user->id, ['controller' => 'Users', 'action' => 'view', $cart->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Item') ?></th>
                    <td><?= $cart->has('item') ? $this->Html->link($cart->item->id, ['controller' => 'Items', 'action' => 'view', $cart->item->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cart->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Size') ?></th>
                    <td><?= $this->Number->format($cart->size) ?></td>
                </tr>
                <tr>
                    <th><?= __('Orderd') ?></th>
                    <td><?= $cart->orderd === null ? '' : $this->Number->format($cart->orderd) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Created') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($cart->created)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Modified') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($cart->modified)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
