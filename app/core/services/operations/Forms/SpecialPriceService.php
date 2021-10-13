<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\services\operations\Forms;

use app\core\repositories\manage\Forms\SpecialPriceRepository;
use app\models\ActiveRecord\Forms\SpecialPrice;
use app\models\Forms\Manage\Forms\SpecialPriceForm;

/**
 * Description of SpecialPriceService
 *
 * @author kotov
 */
class SpecialPriceService
{
    /**
     * 
     * @var SpecialPriceRepository
     */
    protected $specialPrices;
    
    public function __construct(SpecialPriceRepository $specialPrices)
    {
        $this->specialPrices = $specialPrices;
    }


    public function create(SpecialPriceForm $form)
    {
        $specialPriceModel = SpecialPrice::create(
                $form->fieldId, 
                $form->startDate, 
                $form->endDate,
                $form->price);
        $this->specialPrices->save($specialPriceModel);
        return $specialPriceModel;
    }
    
    public function edit($id, SpecialPriceForm $form)
    {
        /** @var SpecialPrice $specialPriceModel */
        $specialPriceModel = $this->specialPrices->get($id);
        $specialPriceModel->edit(
                $form->startDate,
                $form->endDate,
                $form->price);
        $this->specialPrices->save($specialPriceModel);        
    }
    public function remove ($id) 
    {        
        /* @var $valute Valute */
         $specialPriceModel = $this->specialPrices->get($id);
         $this->specialPrices->remove($specialPriceModel);
    }     
}
