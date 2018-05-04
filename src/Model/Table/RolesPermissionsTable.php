<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RolesPermissions Model
 *
 * @method \App\Model\Entity\RolesPermission get($primaryKey, $options = [])
 * @method \App\Model\Entity\RolesPermission newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RolesPermission[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RolesPermission|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RolesPermission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RolesPermission[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RolesPermission findOrCreate($search, callable $callback = null, $options = [])
 */
class RolesPermissionsTable extends Table
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

        $this->setTable('roles_permissions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('id_rol')
            ->requirePresence('id_rol', 'create')
            ->notEmpty('id_rol');

        $validator
            ->integer('id_permiso')
            ->requirePresence('id_permiso', 'create')
            ->notEmpty('id_permiso');

        return $validator;
    }
}
