<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Myitems Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\Myitem newEmptyEntity()
 * @method \App\Model\Entity\Myitem newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Myitem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Myitem get($primaryKey, $options = [])
 * @method \App\Model\Entity\Myitem findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Myitem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Myitem[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Myitem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Myitem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Myitem[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Myitem[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Myitem[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Myitem[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MyitemsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('myitems');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('product_id')
            ->notEmptyString('product_id');

        $validator
            ->scalar('jancode')
            ->allowEmptyString('jancode');

        $validator
            ->scalar('mycategory1')
            ->requirePresence('mycategory1', 'create')
            ->notEmptyString('mycategory1');

        $validator
            ->scalar('mycategory2')
            ->requirePresence('mycategory2', 'create')
            ->notEmptyString('mycategory2');

        $validator
            ->scalar('mycategory3')
            ->requirePresence('mycategory3', 'create')
            ->notEmptyString('mycategory3');

        $validator
            ->scalar('mystore')
            ->allowEmptyString('mystore');

        $validator
            ->scalar('note1')
            ->allowEmptyString('note1');

        $validator
            ->scalar('note2')
            ->allowEmptyString('note2');

        $validator
            ->scalar('note3')
            ->allowEmptyString('note3');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn('product_id', 'Products'), ['errorField' => 'product_id']);

        return $rules;
    }
}
