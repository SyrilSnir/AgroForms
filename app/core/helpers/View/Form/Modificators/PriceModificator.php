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
     * @var string
     */
    protected $alias = '';
    
    /**
     * 
     * @var FormElement
     */
    private $formElement;
    
    /**
     * Текущаяч дата или дата сохраненной заявки
     * @var int
     */
    protected $date;
    
    public function __construct(int $mt = null)
    {
        if ($mt) {
            $this->date = $mt;
        } else {
            $this->date = microtime();
        }
    }


    public function setFormElement(FormElement $formElement): void
    {
        $this->formElement = $formElement;
    }
    
    public function getSpecialPriceElement(): ?SpecialPrice
    {
        $currentDate = date('Y-m-d', $this->date);
        if (!$this->formElement) {
            return null;
        }
        return SpecialPrice::find()
                ->andWhere(['field_id' => $this->formElement->getFieldId()])                
                ->andWhere(['<=', 'start_date' ,new Expression("DATE('$currentDate')") ])
                ->andWhere(['>=', 'end_date', new Expression("DATE('$currentDate')") ])
                ->one();
    }

    public function getAlias(): string
    {
        return $this->alias;
    }    
}
