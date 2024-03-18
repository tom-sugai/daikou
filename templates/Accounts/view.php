<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Account $account
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Account'), ['action' => 'edit', $account->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Account'), ['action' => 'delete', $account->id], ['confirm' => __('Are you sure you want to delete # {0}?', $account->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Accounts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Account'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="accounts view content">
            <h3><?= h($account->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $account->has('user') ? $this->Html->link($account->user->id, ['controller' => 'Users', 'action' => 'view', $account->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($account->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deposit') ?></th>
                    <td><?= $account->deposit === null ? '' : $this->Number->format($account->deposit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Blance') ?></th>
                    <td><?= $account->blance === null ? '' : $this->Number->format($account->blance) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Firstname') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($account->firstname)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Lastname') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($account->lastname)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Address1') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($account->address1)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Address2') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($account->address2)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Tel1') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($account->tel1)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Tel2') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($account->tel2)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Credit') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($account->credit)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
