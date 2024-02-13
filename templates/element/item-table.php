<div class="item-table">
    <p><?= __('new-index Item Table') ?></p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th>image</th>
                    <th>pname</th>
                    <th>price</th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $this->Number->format($item->id) ?></td>
                        <td><?= $this->Html->image($item->product->image,  ['width' => 60, 'height' => 60]) ?></td>
                        <td><?= $item->product->pname ?></td>
                        <td><?= $item->product->price ?></td>    
                        <td class="actions">
                            <?= $this->Html->link(__('intoCart'), ['controller' => 'Carts','action' => 'intoCart', $item->id]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="pctrl">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>