<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $detail_id
 * @property string|null $note1
 * @property string|null $note2
 * @property string|null $note3
 * @property string|null $created
 * @property string|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Detail[] $details
 */
class Order extends Entity
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
        'detail_id' => true,
        'note1' => true,
        'note2' => true,
        'note3' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'details' => true,
    ];
}
