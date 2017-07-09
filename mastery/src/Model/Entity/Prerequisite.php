<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Prerequisite Entity
 *
 * @property int $id
 * @property float $required_marks
 * @property int $pre_id
 * @property int $test_id
 *
 * @property \App\Model\Entity\Test $test
 */
class Prerequisite extends Entity
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
