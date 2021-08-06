<?php

namespace app\core\services\operations\Geography;

use app\core\repositories\manage\Geography\CityRepository;
use app\models\ActiveRecord\Geography\City;
use app\models\Forms\Geography\CityForm;

/**
 * Description of CityService
 *
 * @author kotov
 */
class CityService
{
    /**
     *
     * @var CityRepository 
     */
    protected $cities;
    
    public function __construct(
            CityRepository $repository
            )
    {
        $this->cities = $repository;
    } 
    
    public function create(CityForm $form) : City
    {
        $model = City::create($form->name, $form->region, $form->nameEng);
        $this->cities->save($model);
        return $model;
    }

    public function edit($id, CityForm $form)
    {
        /** @var City $model */
        $model = $this->cities->get($id);
        $model->edit(
                $form->name,
                $form->region,
                $form->nameEng
                );
        $this->cities->save($model); 
    }    
}
