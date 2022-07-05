<?php

namespace app\core\helpers\View\Form\Modificators;

use app\core\helpers\View\Form\FormElements\FormElement;
use app\core\helpers\View\Form\PriceModifyInterface;
use app\models\ActiveRecord\Forms\SpecialPrice;
use yii\db\Expression;

/**
 * Description of PriceModificator
 *
 * @author kotov
 */
abstract class PriceModificator implements PriceModifyInterface
{
    /**
     * 
     * @var FormElement
     */
    private $formElement;
    
    public function setFormElement(FormElement $formElement): void
    {
        $this->formElement = $formElement;
    }
    
    protected function getSpecialPriceElement(): ?SpecialPrice
    {
        $currentDate = date('Y-m-d');
        if (!$this->formElement) {
            return null;
        }
        return SpecialPrice::find()
                ->andWhere(['field_id' => $this->formElement->getFieldId()])                
                ->andWhere(['<=', 'start_date' ,new Expression("DATE('$currentDate')") ])
                ->andWhere(['>=', 'end_date', new Expression("DATE('$currentDate')") ])
                ->one();
    }


}
