<?php

namespace app\models\ActiveRecord\Users;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\Forms\Manage\Users\ManagerRoleForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "manager_roles".
 *
 * @property int $id
 * @property string $name Название роли
 * @property string $name_eng Название роли (ENG)
 *
 * @property ManagerRoleRules[] $managerRoleRules
 */
class ManagerRoles extends ActiveRecord
{
    
    use MultilangTrait;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manager_roles';
    }
    
    public static function create(ManagerRoleForm $form): self
    {
        $model = new self();
        $model->name = $form->name;
        $model->name_eng = $form->nameEng;
        return $model;        
    }
    
    public function edit(ManagerRoleForm $form): void
    {
        $this->name = $form->name;
        $this->name_eng = $form->nameEng;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_eng'], 'required'],
            [['name', 'name_eng'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'name_eng' => 'Name Eng',
        ];
    }

    /**
     * Gets query for [[ManagerRoleRules]].
     *
     * @return ActiveQuery
     */
    public function getManagerRoleRules()
    {
        return $this->hasMany(ManagerRoleRules::class, ['role_id' => 'id']);
    }
}
