<td class="actions">
                        <!--<?= $this->Html->link(__('View'), ['action' => 'view', $cart->id]) ?>-->
                        <!--<?= $this->Html->link(__('Edit'), ['action' => 'edit', $cart->id]) ?>-->
                        <?= $this->Html->link(__('注文する'), ['action' => 'order', $cart->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>