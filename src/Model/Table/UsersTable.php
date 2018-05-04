<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
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
            ->scalar('nombre')
            ->maxLength('nombre', 25)
            ->allowEmpty('nombre');

        $validator
            ->scalar('apellido1')
            ->maxLength('apellido1', 25)
            ->allowEmpty('apellido1');

        $validator
            ->scalar('apellido2')
            ->maxLength('apellido2', 25)
            ->allowEmpty('apellido2');

        $validator
            ->scalar('correo')
            ->maxLength('correo', 100)
            ->allowEmpty('correo');

        $validator
            ->scalar('usuario')
            ->maxLength('usuario', 100)
            ->allowEmpty('usuario');

        $validator
            ->scalar('password')
            ->maxLength('password', 32)
            ->allowEmpty('password');

        $validator
            ->integer('id_rol')
            ->requirePresence('id_rol', 'create')
            ->notEmpty('id_rol');

        return $validator;
    }
}
