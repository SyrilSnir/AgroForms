<?php

namespace app\core\services\operations\Nomenclature;

use app\core\repositories\manage\Nomenclature\UnitRepository;
use app\models\ActiveRecord\Nomenclature\Unit;
use app\models\Forms\Nomenclature\UnitForm;

/**
 * Description of UnitService
 *
 * @author kotov
 */
class UnitService
{
    /**
     *
     * @var UnitRepository 
     */
    protected $units;
    
    public function __construct(
            UnitRepository $unitRepository
            )
    {
        $this->units = $unitRepository;
    }
    
    public function create(UnitForm $form) 
    {
        $unit = Unit::create(
                $form->name, 
                $form->shortName,
                $form->nameEng, 
                $form->shortNameEng                
                );
        $this->units->save($unit);
        return $unit;
    }
    
    public function edit($id ,UnitForm $form) 
    {
        /** @var Unit $unit */
        $unit = $this->units->get($id);
        $unit->edit(
                $form->name, 
                $form->shortName,
                $form->nameEng, 
                $form->shortNameEng                
                );
        $this->units->save($unit);
    }
    
    public function remove ($id) 
    {        
        /* @var $unit Unit */
         $unit = $this->units->get($id);
         $this->units->remove($unit);
    }
}
