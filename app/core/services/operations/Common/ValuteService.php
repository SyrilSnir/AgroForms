<?php

namespace app\core\services\operations\Common;

use app\core\repositories\manage\Common\ValuteRepository;
use app\models\ActiveRecord\Common\Valute;
use app\models\Forms\Common\ValuteForm;

/**
 * Description of ValuteService
 *
 * @author kotov
 */
class ValuteService
{
    /**
     *
     * @var ValuteRepository
     */
    protected $valutes;
    
    function __construct(ValuteRepository $valutes)
    {
        $this->valutes = $valutes;
    }
    
    public function create(ValuteForm $form) 
    {
        $valute = Valute::create(
                $form->name, 
                $form->intName,
                $form->charCode,
                $form->symbol
                );
        $this->valutes->save($valute);
        return $valute;
    }
    
    public function edit($id ,ValuteForm $form) 
    {
        /** @var Valute $valute */
        $valute = $this->valutes->get($id);
        $valute->edit(
                $form->name, 
                $form->intName,
                $form->charCode,
                $form->symbol
                );
        $this->valutes->save($valute);
    }
    
    public function remove ($id) 
    {        
        /* @var $valute Valute */
         $valute = $this->valutes->get($id);
         $this->valutes->remove($valute);
    }    

}
