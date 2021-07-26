<?php

namespace app\core\services\operations\Geography;

use app\core\repositories\manage\Geography\CountryRepository;
use app\models\ActiveRecord\Geography\Country;
use app\models\Forms\Geography\CountryForm;
/**
 * Description of CountryService
 *
 * @author kotov
 */
class CountryService
{
    /**
     * 
     * @var CountryRepository
     */
    protected $countries;
    
    public function __construct(CountryRepository $countries)
    {
        $this->countries = $countries;
    }
    
    public function create(CountryForm $form): Country
    {
        $model = Country::create($form->name, $form->code);
        $this->countries->save($model);
        return $model;
    }
    
    public function edit($id, CountryForm $form)
    {
        /** @var Country $model */
        $model = $this->countries->get($id);
        $model->edit($form->name, $form->code);
        $this->countries->save($model);
    }

}
