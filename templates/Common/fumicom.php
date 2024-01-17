<!-- src/Template/Common/fumicom.ctp -->

<?= $this->fetch('content') ?>

<div class="actions">
    <h3>関連アクション</h3>
    <ul>
    <?php echo $this->Html->link('requestInfo', ['action' => 'requestInfo']) . "<br/>"; ?>
    </ul>
</div>

<div class="sidebar">
    <?= $this->fetch('sidebar') ?>
</div>

