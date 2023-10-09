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
            $data['parameters']['freeCount'] = ceil($standSquare / $metersPerOne);
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
        if (!$this->isComputed() || !key_exists('value', $valuesList)) {
            return 0;
        }
       // $this->contract->stand_square
        $standSquare = $this->contract->stand_square;
        $params = $this->getParameters();
        $freeCount = ceil($standSquare / $params['metersPerOne'] );
        $unitPrice = $params['unitPrice'];
        $blocksCount = count($valuesList['value']);
        if ($unitPrice <= 0 || $blocksCount <= $freeCount) {            
            return 0;
        }
        return $unitPrice * ($blocksCount - $freeCount);
    }

    public function renderHtml(array $valuesList = []): string
    {
        if (key_exists('value', $valuesList)) {
            return $this->view->renderFile('@fields/badge.php',[
                'values' => $valuesList['value'],
                'title' => $this->field->name,
                'isComputed' => $this->isComputed(),
                'price' => $this->getPrice($valuesList),                
                'valute' => $this->field->form->valute->symbol,              
            ]);
        }
        return '';
    }

    public function renderPDF(array $valuesList = []): string
    {
        if (key_exists('value', $valuesList)) {
            return $this->view->renderFile('@fields/badge__pdf.php',[
                'values' => $valuesList['value'],
                'title' => $this->field->name,
                'isComputed' => $this->isComputed(),
                'price' => $this->getPrice($valuesList),                
                'valute' => $this->field->form->valute->symbol,              
            ]);
        }
        return '';       
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
