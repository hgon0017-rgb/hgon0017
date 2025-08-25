<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContactUs Model
 *
 * @method \App\Model\Entity\ContactU newEmptyEntity()
 * @method \App\Model\Entity\ContactU newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ContactU> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContactU get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ContactU findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ContactU patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ContactU> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContactU|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ContactU saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ContactU>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactU>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactU>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactU> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactU>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactU>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactU>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactU> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContactUsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('contact_us');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('full_name')
            ->maxLength('full_name', 255)
            ->requirePresence('full_name', 'create')
            ->notEmptyString('full_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->boolean('email_sent')
            ->requirePresence('email_sent', 'create')
            ->notEmptyString('email_sent');

        return $validator;
    }
}
