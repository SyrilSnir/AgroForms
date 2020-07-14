<?php

namespace app\core\services\operations\Geography;

use app\core\repositories\manage\Geography\RegionRepository;
use app\models\ActiveRecord\Geography\Region;
use app\models\Forms\Geography\RegionForm;

/**
 * Description of RegionService
 *
 * @author kotov
 */
class RegionService
{
    /**
     *
     * @var RegionRepository 
     */
    protected $regions;
    
    public function __construct(
            RegionRepository $repository
            )
    {
        $this->regions = $repository;
    } 
    
    public function create(RegionForm $form) : Region
    {
        $model = Region::create($form->name, $form->country);
        $this->regions->save($model);
        return $model;
    }

    public function edit($id, RegionForm $form)
    {
        /** @var Region $model */
        $model = $this->regions->get($id);
        $model->edit(
                $form->name,
                $form->country
                );
        $this->regions->save($model); 
    }  
}
