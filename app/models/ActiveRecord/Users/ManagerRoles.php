<?php

namespace app\models\ActiveRecord\Users;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\Forms\Manage\Users\ManagerRoleForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "manager_roles".
 *
 * @property int $id
 * @property string $name Название роли
 * @property string $name_eng Название роли (ENG)
 * 
 * @property boolean $u_view Просмотр пользователей
 * @property boolean $u_create Создание пользователей
 * @property boolean $u_edit Редактирование пользователей
 * @property boolean $u_delete Удаление пользователей
 * @property boolean $c_view Просмотр компаний
 * @property boolean $c_create Создание компаний
 * @property boolean $c_edit Редактирование компаний
 * @property boolean $c_delete Удаление компаний
 * @property boolean $d_view Просмотр документов
 * @property boolean $d_create Создание документов
 * @property boolean $d_edit Редактирование документов
 * @property boolean $d_delete Удаление документов
 * @property boolean $co_view Просмотр договоров
 * @property boolean $co_create Создание договоров
 * @property boolean $co_edit Редактирование договоров
 * @property boolean $co_delete Удаление договоров
 * @property boolean $r_view Просмотр рубрикатора
 * @property boolean $r_create Создание раздела рубрикатора
 * @property boolean $r_edit Редактирование раздела рубрикатора
 * @property boolean $r_delete Удаление раздела рубрикатора
 * @property boolean $catalog_view Просмотр каталога
 * @property boolean $catalog_load Загрузка данных
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
        $model->u_view = $form->u_view;        
        $model->c_view = $form->c_view;
        $model->d_view = $form->d_view;
        $model->r_view = $form->r_view;
        $model->co_view = $form->co_view;
        $model->catalog_view = $form->catalog_view;
        $model->catalog_load = $form->catalog_load;
        if ($model->u_view) {
            $model->u_create = $form->u_create;
            $model->u_edit = $form->u_edit;
            $model->u_delete = $form->u_delete;
        } else {
            $model->u_create = false;
            $model->u_edit = false;
            $model->u_delete = false;            
        }
        if ($model->c_view) {
            $model->c_create = $form->c_create;
            $model->c_edit = $form->c_edit;
            $model->c_delete = $form->c_delete;            
        } else {
            $model->c_create = false;
            $model->c_edit = false;
            $model->c_delete = false;            
        }
        if ($model->d_view) {
            $model->d_create = $form->d_create;
            $model->d_edit = $form->d_edit;
            $model->d_delete = $form->d_delete;            
        } else {
            $model->d_create = false;
            $model->d_edit = false;
            $model->d_delete = false;            
        }
        if ($model->r_view) {
            $model->r_create = $form->r_create;
            $model->r_edit = $form->r_edit;
            $model->r_delete = $form->r_delete;            
        } else {
            $model->r_create = false;
            $model->r_edit = false;
            $model->r_delete = false;            
        }
        if ($model->co_view) {
            $model->co_create = $form->co_create;
            $model->co_edit = $form->co_edit;
            $model->co_delete = $form->co_delete;
            
        } else {
            $model->co_create = false;
            $model->co_edit = false;
            $model->co_delete = false;            
        }
        return $model;        
    }
    
    public function edit(ManagerRoleForm $form): void
    {
        $this->name = $form->name;
        $this->name_eng = $form->nameEng;
        $this->u_view = $form->u_view;        
        $this->c_view = $form->c_view;
        $this->d_view = $form->d_view;
        $this->co_view = $form->co_view;
        $this->r_view = $form->r_view;
        $this->catalog_view = $form->catalog_view;
        $this->catalog_load = $form->catalog_load;
        if ($this->u_view) {
            $this->u_create = $form->u_create;
            $this->u_edit = $form->u_edit;
            $this->u_delete = $form->u_delete;
        } else {
            $this->u_create = false;
            $this->u_edit = false;
            $this->u_delete = false;            
        }
        if ($this->c_view) {
            $this->c_create = $form->c_create;
            $this->c_edit = $form->c_edit;
            $this->c_delete = $form->c_delete;            
        } else {
            $this->c_create = false;
            $this->c_edit = false;
            $this->c_delete = false;            
        }
        if ($this->d_view) {
            $this->d_create = $form->d_create;
            $this->d_edit = $form->d_edit;
            $this->d_delete = $form->d_delete;            
        } else {
            $this->d_create = false;
            $this->d_edit = false;
            $this->d_delete = false;            
        }
        if ($this->r_view) {
            $this->r_create = $form->r_create;
            $this->r_edit = $form->r_edit;
            $this->r_delete = $form->r_delete;            
        } else {
            $this->r_create = false;
            $this->r_edit = false;
            $this->r_delete = false;            
        }
        if ($this->co_view) {
            $this->co_create = $form->co_create;
            $this->co_edit = $form->co_edit;
            $this->co_delete = $form->co_delete;
            
        } else {
            $this->co_create = false;
            $this->co_edit = false;
            $this->co_delete = false;            
        }        
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_eng'], 'required'],
            [['name', 'name_eng'], 'string', 'max' => 255],
            [[
                'u_view','u_create','u_edit','u_delete',
                'c_view','c_create','c_edit','c_delete',
                'd_view','d_create','d_edit','d_delete',
                'r_view','r_create','r_edit','r_delete',
                'co_view','co_create','co_edit','co_delete',
              ],'boolean'],            
        ];
    }
    
    public function hasRequests(): bool
    {
        foreach ($this->managerRoleRules as $rule) {
            if ($rule->r_view) {
                return true;
            }
        }
        return false;
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
    
    public function viewAllRequests(): bool 
    {
        return ManagerRoleRules::find()
                ->andFilterWhere(['role_id' => $this->id])
                ->andWhere(['exhibition_id' => null])
                ->andFilterWhere(['r_view' => true])
                ->count() > 0;
    }
    
    public function getAvailableFormIds(): array
    {
        return ArrayHelper::getColumn(ManagerRoleRules::find()
                ->andFilterWhere(['role_id' => $this->id])
                ->andWhere(['is not','form_id', null])
                ->andFilterWhere(['r_view' => true])->asArray()->all(),'form_id');
    }
}
