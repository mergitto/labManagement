<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Subtask Entity
 *
 * @property int $id
 * @property string $subdescription
 * @property string $status
 * @property int $user_id
 * @property \Cake\I18n\Time $start
 * @property \Cake\I18n\Time $end
 * @property int $weight
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Task[] $tasks
 */
class Subtask extends Entity
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
        '*' => true,
        'id' => false
    ];
}
