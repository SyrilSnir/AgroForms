<?php

namespace app\core\helpers\View\Form\FormElements;

use app\models\ActiveRecord\Contract\Contracts;

/**
 * Description of ElementBadge
 *
 * @author kotov
 */
class ElementBadge  extends FormElement implements CountableElementInterface
{    
    /**
     * 
     * @var Contracts
     */
    private $contract;
    
    protected function transformData(array $fieldList, array $valuesList): array
    {
        $data = parent::transformData($fieldList, $valuesList);
      //  $square = $this->
        $metersPerOne = intval($data['parameters']['metersPerOne']);
        $standSquare = $this->contract ? intval($this->contract->stand_square): 0;
        if ($metersPerOne <= 0 && $standSquare <= 0) {
            $data['parameters']['freeCount'] = 0;
        } else {
            $data['parameters']['freeCount'] = intval($standSquare / $metersPerOne);
        }
        if ($this->contract) {
            $data['badge_info'] = [
              'name' => $this->contract->company ? $this->contract->company->member->getName() : 'Демо',
              'middle_name' => $this->contract->company ? $this->contract->company->member->getMiddleName(): 'Демо',
              'surname' => $this->contract->company ? $this->contract->company->member->getSurName() : 'Демо',
              'company' => $this->contract->company ? $this->contract->company->name : 'Демо'
            ];
        }
        if (key_exists('value', $valuesList)) {
            $data['value'] = $valuesList['value'];
        }        
        return $data;
    }
    public function getPrice(array $valuesList = []): int
    {
        return 0;
    }

    public function renderHtml(array $valuesList = []): string
    {
        if (key_exists('value', $valuesList)) {
            return $this->view->renderFile('@fields/badge.php',[
                'values' => $valuesList['value'],
                'title' => $this->field->name,
            ]);
            }
        return '';
    }

    public function renderPDF(array $valuesList = []): string
    {
        return 'BADGE';        
    }
    
    public function getContract(): Contracts
    {
        return $this->contract;
    }

    public function setContract(Contracts $contract): void
    {
        $this->contract = $contract;
    }    
}
