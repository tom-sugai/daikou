    <div class="boxG">
        <?= $this->Html->link(__('Order'), ['action' => 'order', $cart->id]) ?>
        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?>
    </div>
</div>