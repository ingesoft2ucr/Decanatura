<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Loan Entity
 *
 * @property string $id
 * @property int $id_responsables
 * @property \Cake\I18n\FrozenDate $fecha_inicio
 * @property \Cake\I18n\FrozenDate $fecha_devolucion
 * @property string $observaciones
 * @property string $estado
 */
class Loan extends Entity
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
        'id_responsables' => true,
        'fecha_inicio' => true,
        'fecha_devolucion' => true,
        'observaciones' => true,
        'estado' => true,
        'file_solicitud' => true,
        'file_solicitud_dir' => true,
        'file_devolucion' => true,
        'file_devolucion_dir' => true,
    ];
}
