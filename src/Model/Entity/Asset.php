<?php
namespace App\Model\Entity;
use Cake\ORM\Entity;
/**
 * Asset Entity
 *
 * @property string $plaque
 * @property string $type_id
 * @property string $brand
 * @property string $model
 * @property string $series
 * @property string $description
 * @property string $state
 * @property string $image
 * @property int $assigned_to
 * @property int $responsable_id
 * @property string $location_id
 * @property string $sub_location
 * @property int $year
 * @property bool $lendable
 * @property string $observations
 * @property string $dir
 *
 * @property \App\Model\Entity\Type $type
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Location $location
 * * @property \App\Model\Entity\Loan $loan
 */
class Asset extends Entity
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
        'plaque' => true,
        'loan_id' => true,
        'models_id' => true,
        'series' => true,
        'description' => true,
        'state' => true,
        'image' => true,
        'file' => true,
        'file_dir' => true,
        'responsable_id' => true,
        'assigned_to' => true,
        'location_id' => true,
        'sub_location' => true,
        'year' => true,
        'lendable' => true,
        'observations' => true,
        'image_dir' => true,
        'user' => true,
        'location' => true,
        'unique_id' => true,
        'deleted' => true,
        'deletable' => true,
        'brand' => true,
		'type_id' => true
    ];
}