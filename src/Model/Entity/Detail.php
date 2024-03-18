<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Detail Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $size
 * @property string|null $note1
 * @property string|null $note2
 * @property string|null $note3
 * @property string|null $created
 * @property string|null $modified
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Item $item
 */
class Detail extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'order_id' => true,
        'product_id' => true,
        'size' => true,
        'note1' => true,
        'note2' => true,
        'note3' => true,
        'created' => true,
        'modified' => true,
        'order' => true,
        'product' => true,
    ];
}
