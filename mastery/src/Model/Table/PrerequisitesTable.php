<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Prerequisites Model
 *
 * @property \App\Model\Table\TestsTable|\Cake\ORM\Association\BelongsTo $Tests
 * @property \App\Model\Table\TestsTable|\Cake\ORM\Association\BelongsTo $Tests
 *
 * @method \App\Model\Entity\Prerequisite get($primaryKey, $options = [])
 * @method \App\Model\Entity\Prerequisite newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Prerequisite[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Prerequisite|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Prerequisite patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Prerequisite[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Prerequisite findOrCreate($search, callable $callback = null, $options = [])
 */
class PrerequisitesTable extends Table
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

        $this->setTable('prerequisites');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tests', [
            'foreignKey' => 'pre_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tests', [
            'foreignKey' => 'test_id',
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->numeric('required_marks')
            ->requirePresence('required_marks', 'create')
            ->notEmpty('required_marks')
            ->add('required_marks', [
                'minLength' => [
                    'rule' => ['comparison', '>=', 0],
                    'message' => 'Comments must have a substantial body.'
                ],
                'maxLength' => [
                    'rule' => ['comparison', '<=', 100],
                    'message' => 'Comments cannot be too long.'
                ]
            ]);

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
        $rules->add($rules->existsIn(['pre_id'], 'Tests'));
        $rules->add($rules->existsIn(['test_id'], 'Tests'));

        return $rules;
    }
}
