<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Localized\Validation\FrValidation;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Admins
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
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

        $this->table('users');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'photo' => [
                'fields' => [
                    'dir' => 'photo_dir',
                    'size' => 'photo_size',
                    'type' => 'photo_type',
                ],
            ],
        ]);

        $this->belongsToMany('Events',[
          'foreignKey' => 'user_id',
          'targetForeignKey' => 'event_id',
          'joinTable' => 'events_users'
        ]);

        $this->belongsTo('Admins', [
            'foreignKey' => 'admins_id',
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
            ->requirePresence('name', 'create')
            ->notEmpty('name', 'ログインIDが入力されていません');
        $validator
            ->add('name', 'custom', [
                'rule' => function ($value, $context){
                    return (bool) preg_match('/^[a-zA-Z0-9]+$/',$value);
                },
                'message' => '半角英数字で入力してください'
            ]);

        $validator
            ->requirePresence('email')
            ->allowEmpty('email', 'create');
        $validator
            ->add('email', 'valudFormat',[
                'rule' => 'email',
                'message' => 'メールの形式で登録してください'
            ]);

        $validator
            ->allowEmpty('photo', ['create','update']);
        $validator
            ->add('photo', [
                'uploadedFile' => [
                    'rule' => [
                        'uploadedFile', [
                            'types' => [
                                'image/jpeg',
                                'image/png',
                                'image/gif'
                            ],
                            'maxSize' => '0.5MB'
                        ],
                    ],
                'message' => '画像の形式はjpg,png,gifのいずれかにしてください'
                ],
            ]);

        $validator
            ->requirePresence('photo_dir','false')
            ->allowEmpty('photo_dir', 'false');

        $validator
            ->requirePresence('phone')
            ->allowEmpty('phone', 'create');
        $validator
            ->add('phone', 'custom', [
                'rule' => function ($value, $context){
                    return (bool) preg_match('/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/',$value);
                },
                'message' => 'ハイフン付きで入力してください'
            ]);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', 'パスワードが入力されていません');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

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
        $rules->add($rules->existsIn(['admins_id'], 'Admins'));

        return $rules;
    }
}
