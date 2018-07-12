<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Loans Model
 *
 * @method \App\Model\Entity\Loan get($primaryKey, $options = [])
 * @method \App\Model\Entity\Loan newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Loan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Loan|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Loan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Loan[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Loan findOrCreate($search, callable $callback = null, $options = [])
 */
class LoansTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('loans');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Josegonzalez/Upload.Upload', [

            'file_solicitud' => [
                'fields' => [
                    'dir' => 'file_solicitud_dir',
                    'size' => 'file_solicitud_size',
                    'type' => 'file_solicitud_type',
                ],
                'path' => 'webroot{DS}files{DS}{model}{DS}{field}{DS}{field-value:unique_id}{DS}',
                'nameCallback' => function ($table, $entity, $data, $field, $settings) {
                    return strtolower($data['name']);
                },

                'keepFilesOnDelete' => false
            ],
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'id_responsables'
        ]);
        
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->scalar('id')
            ->maxLength('id', 255)
            ->allowEmpty('id', 'create');

        $validator
            ->integer('id_responsables')
            ->notEmpty('id_responsables');

        $validator
            ->date('fecha_inicio')
            ->notEmpty('fecha_inicio','Ingrese una fecha de inicio');

        $validator
            ->date('fecha_devolucion')
            ->allowEmpty('fecha_devolucion');

        $validator
            ->scalar('observaciones')
            ->maxLength('observaciones', 4294967295)
            ->allowEmpty('observaciones');

        $validator
            ->scalar('estado')
            ->maxLength('estado', 255)
            ->allowEmpty('estado');

        $validator
            ->maxLength('file_devolucion', 255)
            ->allowEmpty('file_devolucion');

        $validator
            ->maxLength('file_devolucion_dir', 255)
            ->allowEmpty('file_devolucion_dir');

        $validator
            ->maxLength('file_solicitud', 255)
            ->allowEmpty('file_solicitud');

        $validator
            ->maxLength('file_solicitud_dir', 255)
            ->allowEmpty('file_solicitud_dir');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['id_responsables'], 'Users'));
        return $rules;
    }
}
