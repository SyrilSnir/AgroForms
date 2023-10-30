<?php

namespace app\core\services\operations\Exhibition;

use app\core\repositories\manage\Exhibition\CatalogRepository;
use app\core\services\operations\DataManqageInterface;
use app\models\ActiveRecord\Exhibition\Catalog;
use app\models\ActiveRecord\Exhibition\CatalogContacts;
use app\models\Forms\Manage\Exhibition\CatalogForm;
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
        /** @var CatalogForm $form */
        $model = Catalog::create($form);
        $this->repository->save($model);
        if (!empty($form->contactForms)) {
            foreach ($form->contactForms as $contactForm) {
                $contact = CatalogContacts::create(
                        $model->id, 
                        $contactForm->site, 
                        $contactForm->email, 
                        $contactForm->phone);
                $contact->save();
            }
        }
        
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
