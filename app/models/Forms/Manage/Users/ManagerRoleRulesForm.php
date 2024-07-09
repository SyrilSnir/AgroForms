<?php

namespace app\models\Forms\Manage\Users;

use app\models\ActiveRecord\Users\ManagerRoleRules;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of ManagerRoleRulesForm
 *
 * @author kotov
 */
class ManagerRoleRulesForm extends ManageForm
{
    public $roleId;
    
    public $exhibitionId;

    public $exhibitionName;
    
    public $formId;
    
    public $formName;
    
    public $roleName;

    public $accept;
    
    public $pay;
    
    public $delete;
    
    public $view;
    
    public $publicate;


    public function __construct(ManagerRoleRules $model = null, $config = [])
    {
        parent::__construct($config);
        if ($model) {
            $this->roleId = $model->role_id;
            $this->formId = $model->form_id;
            $this->view = $model->r_view;
            $this->exhibitionId = $model->exhibition_id;
            if ($this->view == false) {
                $this->accept = false;
                $this->pay = false;
                $this->delete = false;
                $this->publicate = false;                
            } else {
                $this->accept = $model->r_accept;
                $this->pay = $model->r_pay;
                $this->delete = $model->r_delete;
                $this->publicate = $model->r_publicate;                
            }
            $this->formName = $model->form ? $model->form->title : '';
            $this->roleName = $model->role ? $model->role->name : '';
            
        }
        
    }
    
    public function rules(): array
    {
        return [
            [['roleId'],'required'],
            [['roleId','formId','exhibitionId'],'integer'],
            [['formName','roleName','exhibitionName'],'string'],
            [['accept','pay', 'delete','view', 'publicate'],'boolean'],            
        ];
    } 
    
    public function attributeLabels(): array
    {
        return [
            'formName' => t('Form'),
            'roleName' => t('Role name'),
            'exhibitionName' => t('Exhibition'),
            'view' => t('View applications'),
            'accept' => t('Accept/reject application'),
            'pay' => t('Changing payment status'),
            'delete' => t('Deleting applications'),
            'publicate' => t('Post an application'),
            
        ];
    }
    
    public function hasExhibition(): bool 
    {
        return !empty($this->exhibitionId);
    }
}
