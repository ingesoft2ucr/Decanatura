<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ActivityLogs Model
 *
 * @method \App\Model\Entity\ActivityLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\ActivityLog newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ActivityLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ActivityLog|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivityLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ActivityLog[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ActivityLog findOrCreate($search, callable $callback = null, $options = [])
 */
class ActivityLogsTable extends Table
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

        $this->setTable('activity_logs');
        $this->setDisplayField('idLog');
        $this->setPrimaryKey('idLog');

        $this->belongsTo('Users', [
            'foreignKey' => 'idUser',
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
            ->integer('idLog')
            ->allowEmpty('idLog', 'create');

        $validator
            ->dateTime('DateAndTime')
            ->requirePresence('DateAndTime', 'create')
            ->notEmpty('DateAndTime');

        $validator
            ->scalar('currentModule')
            ->maxLength('currentModule', 50)
            ->allowEmpty('currentModule');

        $validator
            ->scalar('idUser')
            ->maxLength('idUser', 15)
            ->requirePresence('idUser', 'create')
            ->notEmpty('idUser');

        $validator
            ->scalar('userAction')
            ->maxLength('userAction', 100)
            ->requirePresence('userAction', 'create')
            ->notEmpty('userAction');

        $validator
            ->scalar('message')
            ->maxLength('message', 500)
            ->allowEmpty('message');

        return $validator;
    }
}
