<?php

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\FieldLabelsRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Forms\FieldLabels;
use app\models\Forms\Manage\Forms\FieldLabelForm;
use app\models\Forms\Manage\ManageForm;
use yii\db\ActiveRecord;

/**
 * Description of FieldLabelService
 *
 * @author kotov
 */
class FieldLabelService implements DataManqageInterface
{
     /**
     * 
     * @var FieldLabelsRepository
     */
    protected $repository;
    
    public function __construct(FieldLabelsRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function create(ManageForm $form): ActiveRecord
    {
        /** @var FieldLabelForm $form */
        $model = FieldLabels::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit(int $id, ManageForm $form): void
    {
        /** @var FieldLabels $hall */
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
