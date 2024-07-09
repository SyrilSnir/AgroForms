<?php

namespace app\models\ActiveRecord\Users;

use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\ActiveRecord\Forms\Form;
use app\models\Forms\Manage\Users\ManagerRoleRulesForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "manager_role_rules".
 *
 * @property int $id
 * @property int $role_id Id роли
 * @property int $form_id Id формы
 * @property int $exhibition_id Id выставки
 * @property int $r_view Просмотр заявок
 * @property int $r_accept Принять/отклонить заявку
 * @property int $r_publicate Опубликовать заявку
 * @property int $r_pay Изменение статуса оплаты
 * @property int $r_delete Удаление заявок
 *
 * @property Exhibition|null $exhibition
 * @property Form $form
 * @property ManagerRoles $role
 */
class ManagerRoleRules extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manager_role_rules';
    }
    
    public static function create(ManagerRoleRulesForm $form) :self
    {
        $model = new self();
        $model->form_id = $form->formId;
        $model->role_id = $form->roleId;
        $model->exhibition_id = $form->exhibitionId;
        $model->r_view = $form->view;
        if ($model->r_view == false) {
            $model->r_accept = false;
            $model->r_delete = false;
            $model->r_publicate = false;
            $model->r_pay = false;
        } else {
            $model->r_accept = $form->accept;
            $model->r_delete = $form->delete;
            $model->r_publicate = $form->publicate;
            $model->r_pay = $form->pay;
        }
        return $model;
    }
    
    public function edit(ManagerRoleRulesForm $form): void
    {
        if ($form->view == false) {
            $this->r_view = false;
            $this->r_accept = false;
            $this->r_delete = false;
            $this->r_publicate = false;
            $this->r_pay = false;
        } else {
            $this->r_view = $form->view;
            $this->r_accept = $form->accept;
            $this->r_delete = $form->delete;
            $this->r_publicate = $form->publicate;
            $this->r_pay = $form->pay;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id'], 'required'],
            [['role_id', 'form_id','exhibition_id'], 'integer'],
            [['r_view', 'r_accept', 'r_publicate', 'r_pay', 'r_delete'], 'boolean'],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => Form::class, 'targetAttribute' => ['form_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => ManagerRoles::class, 'targetAttribute' => ['role_id' => 'id']],
            [['exhibition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exhibition::class, 'targetAttribute' => ['exhibition_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Form]].
     *
     * @return ActiveQuery|null
     */
    public function getForm()
    {
        if (!$this->form_id) {
            return null;
        }
        return $this->hasOne(Form::class, ['id' => 'form_id']);
    }
    
    /**
     * Gets query for [[Exhibition]].
     *
     * @return ActiveQuery|null
     */
    public function getExhibition()
    {
        if (!$this->exhibition_id) {
            return null;
        }
        return $this->hasOne(Form::class, ['id' => 'form_id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(ManagerRoles::class, ['id' => 'role_id']);
    }
}
