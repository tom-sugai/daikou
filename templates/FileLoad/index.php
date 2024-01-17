<?= $this->Form->create($fileload, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('ファイル・アップロード') ?></legend>
        <?php
            echo $this->Form->control('addToDir');
            echo $this->Form->file('csv');
        ?>
    </fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>