<?= "This is setCsvClientlist method. !!" ?>
<div class="csvClientListForm">
			<?= $this->Form->create(null, ['type' => 'post', 'url' => ['action' => 'get-csv-client-name']]) ?>
		    <div class="csv-sel"><?= $this->Form->select('select-1', $csv_list, array('empty' => 'CSVを選択', 'width' => 40)) ?></div>
			<div class="csv-sel"><?= $this->Form->select('select-2', $client_list, array('empty' => 'Clientを選択', 'width' => 40)) ?></div>
            <div class="csv-sel"><?= $this->Form->submit(__('Submit')) ?></div>
		    <?= $this->Form->end() ?>
</div>