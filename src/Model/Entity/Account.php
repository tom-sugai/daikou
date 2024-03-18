<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Account Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $address1
 * @property string|null $address2
 * @property string $tel1
 * @property string|null $tel2
 * @property string $credit
 * @property int|null $deposit
 * @property int|null $blance
 *
 * @property \App\Model\Entity\User $user
 */
class Account extends Entity
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
        'firstname' => true,
        'lastname' => true,
        'address1' => true,
        'address2' => true,
        'tel1' => true,
        'tel2' => true,
        'credit' => true,
        'deposit' => true,
        'blance' => true,
        'user' => true,
    ];
}
