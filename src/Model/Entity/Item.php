<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $category
 * @property string $jancode
 * @property string|null $pname
 * @property string|null $brand
 * @property string|null $store
 * @property string|null $image
 * @property string|null $site
 * @property string|null $created
 * @property string|null $modified
 *
 * @property \App\Model\Entity\User $user
 */
class Item extends Entity
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
        'user_id' => true,
        'product_id' => true,
        'jancode' => true,
        'store' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
}
