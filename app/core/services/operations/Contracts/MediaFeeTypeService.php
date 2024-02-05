<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\core\services\operations\Contracts;

use app\core\repositories\manage\Contract\MediaFeeTypeRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Contract\MediaFeeTypes;
use app\models\Forms\Manage\Contract\MediaFeeTypeForm;
use app\models\Forms\Manage\ManageForm;
use yii\db\ActiveRecord;

/**
 * Description of MediaFeeTypeService
 *
 * @author kotov
 */
class MediaFeeTypeService implements DataManqageInterface 
{
    /**
     * 
     * @var MediaFeeTypeRepository
     */
    protected $repository;
    
    public function __construct(MediaFeeTypeRepository $repository) 
    {
        $this->repository = $repository;
    }

        
    //put your code here
    public function create(ManageForm $form): ActiveRecord 
    {
        /** @var MediaFeeTypeForm $form */
        $model = MediaFeeTypes::create($form);
        $this->repository->save($model);
        return $model;        
    }

    public function edit(int $id, ManageForm $form): void 
    {
        /** @var MediaFeeTypeForm $form */
        $model = $this->repository->get($id);
        $model->edit($form);
        $this->repository->save($model);        
    }

    public function remove(int $id): void 
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);        
    }
}
