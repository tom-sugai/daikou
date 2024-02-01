    <div class="boxG">
        <?= $this->Form->postLink(__('削除する'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
    </div>
</div>