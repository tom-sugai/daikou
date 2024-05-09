<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Csvstores Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\Csvstore newEmptyEntity()
 * @method \App\Model\Entity\Csvstore newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Csvstore[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Csvstore get($primaryKey, $options = [])
 * @method \App\Model\Entity\Csvstore findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Csvstore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Csvstore[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Csvstore|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Csvstore saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Csvstore[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Csvstore[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Csvstore[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Csvstore[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CsvstoresTable extends Table
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

        $this->setTable('csvstores');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
            ->scalar('user_id')
            ->notEmptyString('user_id');

        $validator
            ->scalar('csvname')
            ->requirePresence('csvname', 'create')
            ->notEmptyString('csvname');

        $validator
            ->integer('lineno')
            ->requirePresence('lineno', 'create')
            ->notEmptyString('lineno');

        $validator
            ->scalar('codeformat')
            ->requirePresence('codeformat', 'create')
            ->notEmptyString('codeformat');

        $validator
            ->scalar('code')
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

        $validator
            ->integer('existpdb')
            ->allowEmptyString('existpdb');

        $validator
            ->integer('hitsyahoo')
            ->allowEmptyString('hitsyahoo');

        $validator
            ->scalar('mycategory1')
            ->allowEmptyString('mycategory1');

        $validator
            ->scalar('mycategory2')
            ->allowEmptyString('mycategory2');

        $validator
            ->scalar('mycategory3')
            ->allowEmptyString('mycategory3');

        $validator
            ->scalar('mystore')
            ->allowEmptyString('mystore');

        $validator
            ->integer('product_id')
            ->allowEmptyString('product_id');

        $validator
            ->scalar('category')
            ->allowEmptyString('category');

        $validator
            ->scalar('brand')
            ->allowEmptyString('brand');

        $validator
            ->scalar('pname')
            ->allowEmptyString('pname');

        $validator
            ->integer('price')
            ->allowEmptyString('price');

        $validator
            ->scalar('store')
            ->allowEmptyString('store');

        $validator
            ->scalar('imageurl')
            ->allowEmptyFile('imageurl');

        $validator
            ->scalar('siteurl')
            ->allowEmptyString('siteurl');

        $validator
            ->integer('published')
            ->allowEmptyString('published');

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
