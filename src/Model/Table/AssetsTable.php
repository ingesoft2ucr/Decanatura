<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Imagine;

/**
 * Assets Model
 *
 * @property \App\Model\Table\TypesTable|\Cake\ORM\Association\BelongsTo $Types
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 *
 * @method \App\Model\Entity\Asset get($primaryKey, $options = [])
 * @method \App\Model\Entity\Asset newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Asset[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Asset|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Asset patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Asset[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Asset findOrCreate($search, callable $callback = null, $options = [])
 */
class AssetsTable extends Table
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

        $this->setTable('assets');
        $this->setDisplayField('plaque');
        $this->setPrimaryKey('plaque');
        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'image' => [
                'fields' => [
                    'dir' => 'image_dir',
                    'size' => 'image_size',
                    'type' => 'image_type',
                ],
                'path' => 'webroot{DS}files{DS}{model}{DS}{field}{DS}{field-value:unique_id}{DS}',
                'nameCallback' => function ($table, $entity, $data, $field, $settings) {
                    return strtolower($data['name']);
                },
                'transformer' =>  function ($table, $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);

                    // Store the thumbnail in a temporary file
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;

                    // Use the Imagine library to DO THE THING
                    $size = new \Imagine\Image\Box(160, 160);
                    $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                    $imagine = new \Imagine\Gd\Imagine();

                    // Save that modified file to our temp file
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp);

                    // Now return the original *and* the thumbnail
                    return [
                        $data['tmp_name'] => $data['name'],
                        $tmp => 'thumbnail-' . $data['name'],
                    ];
                },
                'deleteCallback' => function ($path, $entity, $field, $settings) {
                    // When deleting the entity, both the original and the thumbnail will be removed
                    // when keepFilesOnDelete is set to false
                    return [
                        $path . $entity->{$field},
                        $path . 'thumbnail-' . $entity->{$field}
                    ];
                },

                'keepFilesOnDelete' => false
            ],

            'file' => [
                'fields' => [
                    'dir' => 'file_dir',
                    'size' => 'file_size',
                    'type' => 'file_type',
                ],
                'path' => 'webroot{DS}files{DS}{model}{DS}{field}{DS}{field-value:unique_id}{DS}',
                'nameCallback' => function ($table, $entity, $data, $field, $settings) {
                    return strtolower($data['name']);
                },

                'keepFilesOnDelete' => false
            ],
        ]);


        $this->belongsTo('Models', [
            'foreignKey' => 'models_id'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'responsable_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'assigned_to'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Loans', [
            'foreignKey' => 'loan_id',
            'joinType' => 'INNER'
        ]);
		$this->belongsTo('Types', [
            'foreignKey' => 'type_id',
            'joinType' => 'INNER'
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
            ->scalar('plaque')
            ->maxLength('plaque', 255)
            ->notEmpty('plaque', 'Debe ingresar una placa');

        $validator
            ->scalar('series')
            ->maxLength('series', 255)
            ->allowEmpty('series');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->notEmpty('description','Debe ingresar una descripción');

        $validator
            ->scalar('state')
            ->maxLength('state', 255)
            ->notEmpty('state','Debe ingresar un estado');

        $validator
            ->scalar('sub_location')
            ->maxLength('sub_location', 255)
            ->allowEmpty('sub_location');

        $validator
            ->scalar('year')
            ->add('year', 'validFormat',[
                'rule' => array('custom', '/^[0-9]{4}$/'),
                'message' => 'El año debe de tener el formato yyyy'
                ])
            ->notEmpty('year','Debe ingresar un año');

        $validator
            ->boolean('lendable')
            ->requirePresence('lendable', 'create')
            ->notEmpty('lendable');

        $validator
            ->scalar('observations')
            ->maxLength('observations', 4294967295)
            ->allowEmpty('observations');

        $validator
            ->maxLength('image', 255)
            ->allowEmpty('image');

        $validator
            ->scalar('image_dir')
            ->maxLength('image_dir', 255)
            ->allowEmpty('image_dir');

        $validator
            ->maxLength('file', 255)
            ->allowEmpty('file');

        $validator
            ->scalar('file_dir')
            ->maxLength('file_dir', 255)
            ->allowEmpty('file_dir');
        
        $validator
            ->scalar('unique_id')
            ->maxLength('unique_id', 255)
            ->allowEmpty('unique_id');
            
        $validator
            ->scalar('location_id')
            ->notEmpty('location_id');

        $validator
            ->scalar('assigned_to')
            ->notEmpty('assigned_to');

        $validator
            ->scalar('responsable_id')
            ->notEmpty('responsable_id');
            
        $validator
            ->scalar('models_id')
            ->maxLength('models_id', 255)
            ->allowEmpty('models_id');

        $validator
            ->scalar('brand')
            ->maxLength('brand', 255)
            ->allowEmpty('brand');
			
		$validator
            ->scalar('type_id')
			->maxLength('type_id', 255)
            ->notEmpty('type_id');
            
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
        $rules->add($rules->existsIn(['responsable_id'], 'Users'));
        $rules->add($rules->existsIn(['assigned_to'], 'Users'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['loan_id'], 'Loans'));
        $rules->add($rules->existsIn(['models_id'], 'Models'));
		$rules->add($rules->existsIn(['type_id'], 'Types'));

        return $rules;
    }
}
