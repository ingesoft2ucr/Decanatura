<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ActivityLog Entity
 *
 * @property int $idLog
 * @property \Cake\I18n\FrozenTime $DateAndTime
 * @property string $currentModule
 * @property string $idUser
 * @property string $userAction
 * @property string $message
 *
 * @property \App\Model\Entity\User $user
 */
class ActivityLog extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'DateAndTime' => true,
        'currentModule' => true,
        'idUser' => true,
        'userAction' => true,
        'message' => true,
        'user' => true
    ];
}
