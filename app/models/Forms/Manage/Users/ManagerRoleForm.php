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
    
    public function __construct(ManagerRoles $model, $config = [])
    {
        parent::__construct($config);
        if ($model) {
            $this->name = $model->name;
            $this->nameEng = $model->name_eng;
        }        
    }
    
    public function rules(): array
    {
        return [
            [['name'],'required'],
            [['name','nameEng'],'string'],
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'name' => t('Role name'),
            'nameEng' => t('Role name') . ' (ENG)',
        ];
    }
        
        
}
