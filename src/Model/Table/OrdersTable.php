<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


/**
 * Orders Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Order newEmptyEntity()
 * @method \App\Model\Entity\Order newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Order> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Order findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Order> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Order saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Order>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Order>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Order>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Order> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Order>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Order>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Order>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Order> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('orders');
        $this->setPrimaryKey('id');

        // 自动维护 created 和 modified 字段
        $this->addBehavior('Timestamp');

        // 订单属于用户（前提：你有 users 表）
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT', // 允许匿名订单（非必填）
        ]);
    }


    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('name', 'Full name is required')
            ->maxLength('name', 255)

            ->notEmptyString('address', 'Address is required')

            ->notEmptyString('phone', 'Phone number is required')
            ->regex('phone', '/^[0-9\-\+\s]+$/', 'Please enter a valid phone number')

            ->notEmptyString('payment_method', 'Please select a payment method');
        $validator
            ->notEmptyString('payment_method', 'Please select a payment method');

        $validator->add('card_number', 'validCard', [
            'rule' => ['custom', '/^[0-9]{13,19}$/'],
            'message' => 'Card number must be 13-19 digits',
            'on' => function ($context) {
                return isset($context['data']['payment_method']) && $context['data']['payment_method'] === 'credit_card';
            }
        ]);

        $validator->add('exp_date', 'validDate', [
            'rule' => ['custom', '/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
            'message' => 'Expiration date must be in MM/YY format',
            'on' => function ($context) {
                return isset($context['data']['payment_method']) && $context['data']['payment_method'] === 'credit_card';
            }
        ]);

        $validator->add('cvc', 'validCvc', [
            'rule' => ['custom', '/^[0-9]{3,4}$/'],
            'message' => 'CVC must be 3 or 4 digits',
            'on' => function ($context) {
                return isset($context['data']['payment_method']) && $context['data']['payment_method'] === 'credit_card';
            }
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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
