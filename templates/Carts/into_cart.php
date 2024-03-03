<div class="carts form large-9 medium-8 columns content">
    <?= $this->Form->create($cart) ?>
        <fieldset >
            <legend style="font-size:1.2rem;"><?= __('注文情報入力') ?></legend>
            <?= $this->Form->control('user_id', ['options' => $users]); ?>
            <?= $this->Form->control('item_id', ['options' => $items]); ?>
            <?= $this->Form->control('size'); ?>
            <?= $this->Form->control('orderd'); ?>
            <?= $this->Form->control('note1',['label' => ['style' => 'font-size:1.0rem']]) ?>
            <?= $this->Form->control('note2',['label' => ['style' => 'font-size:1.0rem']]) ?>
            <?= $this->Form->control('note3',['label' => ['style' => 'font-size:1.0rem']]) ?>
        </fieldset>
    <?= $this->Form->button(__('save cart')) ?>
    <?= $this->Form->end() ?>
</div>