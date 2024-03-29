<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cart->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Carts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="carts form content">
            <?= $this->Form->create($cart) ?>
            <fieldset>
                <legend><?= __('Edit Cart') ?></legend>
                <?= $this->Form->control('user_id', ['options' => $users]); ?>
                <?= $this->Form->control('item_id', ['options' => $items]); ?>
                <?= $this->Form->control('size'); ?>
                <?= $this->Form->control('orderd'); ?>
                <?= $this->Form->control('note1',['label' => ['style' => 'font-size:1.0rem']]) ?>
                <?= $this->Form->control('note2',['label' => ['style' => 'font-size:1.0rem']]) ?>
                <?= $this->Form->control('note3',['label' => ['style' => 'font-size:1.0rem']]) ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
