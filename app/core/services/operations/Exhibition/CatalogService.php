<?php

namespace app\core\services\operations\Exhibition;

use app\core\repositories\manage\Exhibition\CatalogRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Exhibition\Catalog;
use app\models\Forms\Manage\ManageForm;
use yii\db\ActiveRecord;

/**
 * Description of CatalogService
 *
 * @author kotov
 */
class CatalogService implements DataManqageInterface
{
    
    public function __construct(CatalogRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 
     * @var CatalogRepository
     */
    protected $repository;
    
    public function create(ManageForm $form): ActiveRecord
    {
        $model = Catalog::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit(int $id, ManageForm $form): void
    {
        
    }

    public function remove(int $id): void
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
    
    public function clearForExhibition(int $exhibitionId) :void
    {
        $models = $this->repository->getByExhibition($exhibitionId);
        foreach ($models as $model) {
            $this->repository->remove($model);
        }
    }    
    
  //  private function _afterCreate(M)
}
