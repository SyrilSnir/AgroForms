<?php

namespace app\models\Forms\Manage\Users;

use app\models\ActiveRecord\Users\ManagerRoles;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of ManagerRoleForm
 *
 * @author kotov
 */
class ManagerRoleForm extends ManageForm
{
    public $name;
    
    public $nameEng;
    
    public $u_view;
    public $u_create;
    public $u_edit;
    public $u_delete;
    
    public $c_view;
    public $c_create;
    public $c_edit;
    public $c_delete;
    
    public $d_view;
    public $d_create;
    public $d_edit;
    public $d_delete;
    
    public $r_view;
    public $r_create;
    public $r_edit;
    public $r_delete;
    
    public $co_view;
    public $co_create;
    public $co_edit;
    public $co_delete;
    
    public function __construct(ManagerRoles $model, $config = [])
    {
        parent::__construct($config);
        if ($model) {
            $this->name = $model->name;            
            $this->nameEng = $model->name_eng;
            $this->u_view = $model->u_view;
            $this->d_view = $model->d_view;
            $this->c_view = $model->c_view;
            $this->co_view = $model->co_view;
            $this->r_view = $model->r_view;
            if ($model->u_view) {
                $this->u_create = $model->u_create;
                $this->u_edit = $model->u_edit;
                $this->u_delete = $model->u_delete;
            }
            if ($model->c_view) {
                $this->c_create = $model->c_create;
                $this->c_edit = $model->c_edit;
                $this->c_delete = $model->c_delete;
            }
            if ($model->d_view) {
                $this->d_create = $model->d_create;
                $this->d_edit = $model->d_edit;
                $this->d_delete = $model->d_delete;
            }
            if ($model->r_view) {
                $this->r_create = $model->r_create;
                $this->r_edit = $model->r_edit;
                $this->r_delete = $model->r_delete;
            }
            if ($model->co_view) {
                $this->co_create = $model->co_create;
                $this->co_edit = $model->co_edit;
                $this->co_delete = $model->co_delete;
            }
        }       
    }
    
    public function rules(): array
    {
        return [
            [['name'],'required'],
            [['name','nameEng'],'string'],
            [[
                'u_view','u_create','u_edit','u_delete',
                'c_view','c_create','c_edit','c_delete',
                'd_view','d_create','d_edit','d_delete',
                'r_view','r_create','r_edit','r_delete',
                'co_view','co_create','co_edit','co_delete',
              ],'boolean'],
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'name' => t('Role name'),
            'nameEng' => t('Role name') . ' (ENG)',
            'u_view' => t('View users'),
            'u_create' => t('Creating a user'),
            'u_edit' => t('Editing a user'),
            'u_delete' => t('Deleting a user'),            
            'c_view' => t('View companies'),
            'c_create' => t('Creating a company'),
            'c_edit' => t('Editing a company'),
            'c_delete' => t('Deleting a company'),            
            'd_view' => t('View documents'),
            'd_create' => t('Creating a document'),
            'd_edit' => t('Editing a document'),
            'd_delete' => t('Deleting a document'),
            'co_view' => t('View contracts'),
            'co_create' => t('Creating a contract'),
            'co_edit' => t('Editing a contract'),
            'co_delete' => t('Deleting a contract'),
            'r_view' => t('View the rubricator'),
            'r_create' => t('Creating a rubricator section'),
            'r_edit' => t('Editing a rubricator section'),
            'r_delete' => t('Deleting a rubricator section'),            
        ];
    }                
}
