<?php

namespace app\models\Forms\Manage\Users;

use app\models\ActiveRecord\Users\User;
use yii\db\Query;
use yii\helpers\ArrayHelper;


/**
 * Description of MemberForm
 *
 * @author kotov
 */
class MemberForm extends UserManageForm
{
    const SCENARIO_PROFILE_UPDATE = 'profileUpdate';
      
    public function scenarios():array
    {
        return ArrayHelper::merge([
            self::SCENARIO_PROFILE_UPDATE => [
                'phone', 'birthday', 'gender', 'position'
            ]
        ], parent::scenarios());
    }

    public function rules()
    {
        $userId = $this->userId;
        $rules = [
            [['login','email'],'required'],
            ['login','unique',
                'targetClass'=> User::class,
                'filter' => function(Query $query) use ($userId) {
                    $query->andFilterWhere(['<>', 'id', $userId])
                            ->andWhere(['deleted' => false]);
                },
                'message' => t('The user with the specified data is already registered'),
                'on' => self::SCENARIO_UPDATE
            ],
            ['email','unique',
                'targetClass'=> User::class,
                'filter' => function(Query $query) use ($userId) {
                    $query->andFilterWhere(['<>', 'id', $userId]);
                },
                'message' => t('The user with the specified data is already registered'),
                'on' => self::SCENARIO_UPDATE                        
            ],            
        ];     
        return ArrayHelper::merge(parent::rules(), $rules);
    }    
}
