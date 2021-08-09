<?php

namespace app\core\services\operations\Users;

use app\core\repositories\manage\Users\UserTypeRepository;
use app\models\ActiveRecord\Users\UserType;
use app\models\Forms\Manage\Users\UserTypeForm;

/**
 * Description of UserTypeService
 *
 * @author kotov
 */
class UserTypeService
{
    /**
     *
     * @var UserTypeRepository 
     */
    protected $userTypes;
    
    public function __construct(
            UserTypeRepository $userTypeRepository
            )
    {
        $this->userTypes = $userTypeRepository;
    }
    
    public function edit($id ,UserTypeForm $form) 
    {
        /** @var UserType $userType */
        $userType = $this->userTypes->get($id);
        $userType->setName($form->name,$form->nameEng);
        $this->userTypes->save($userType);
    }
}
