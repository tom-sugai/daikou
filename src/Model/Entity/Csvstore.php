<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Csvstore Entity
 *
 * @property int $id
 * @property string $user_id
 * @property string $csvname
 * @property int $lineno
 * @property string $codeformat
 * @property string $code
 * @property int|null $existpdb
 * @property int|null $hitsyahoo
 * @property string|null $mycategory1
 * @property string|null $mycategory2
 * @property string|null $mycategory3
 * @property string|null $mystore
 * @property int|null $product_id
 * @property string|null $category
 * @property string|null $brand
 * @property string|null $pname
 * @property int|null $price
 * @property string|null $store
 * @property string|null $imageurl
 * @property string|null $siteurl
 * @property int|null $published
 * @property string|null $created
 * @property string|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Product $product
 */
class Csvstore extends Entity
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
        'csvname' => true,
        'lineno' => true,
        'codeformat' => true,
        'code' => true,
        'existpdb' => true,
        'hitsyahoo' => true,
        'mycategory1' => true,
        'mycategory2' => true,
        'mycategory3' => true,
        'mystore' => true,
        'product_id' => true,
        'category' => true,
        'brand' => true,
        'pname' => true,
        'price' => true,
        'store' => true,
        'imageurl' => true,
        'siteurl' => true,
        'published' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'product' => true,
    ];
}
