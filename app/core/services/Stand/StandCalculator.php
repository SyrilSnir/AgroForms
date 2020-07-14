<?php

namespace app\core\services\Stand;

use app\core\repositories\readModels\Forms\StandReadRepository;
use app\models\ActiveRecord\Forms\Stand;
use app\models\Forms\Requests\StandForm;

/**
 * Description of StandCalculator
 *
 * @author kotov
 */
class StandCalculator
{
    /**
     *
     * @var StandForm
     */
    protected $form;
    
    public function __construct(StandForm $form)
    {
        $this->form = $form;
    }

    /**
     * 
     * @return int
     */
    public function calculate():int
    {
        /** @var Stand $stand */
        $stand = StandReadRepository::findById($this->form->standId);
        $digitPrice = $stand->digit_price;
        return ($this->form->square * $stand->price);
        
    }
}
