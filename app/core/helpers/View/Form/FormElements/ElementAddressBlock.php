<?php

namespace app\core\helpers\View\Form\FormElements;

/**
 * Description of ElementAddressForm
 *
 * @author kotov
 */
class ElementAddressBlock extends FormElement implements CountableElementInterface
{    
    protected function transformData(array $fieldList, array $valuesList): array
    {
        $data = parent::transformData($fieldList, $valuesList);
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
        $params = $this->getParameters();
        $freeCount = $params['freeCount'];
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
            return $this->view->renderFile('@fields/address.php',[
                'values' => $valuesList['value'],
                'price' => $this->getPrice($valuesList),
                'isComputed' => $this->isComputed(),
                'valute' => $this->field->form->valute->symbol,
                'title' => $this->field->name,
            ]);
            }
        return '';
    }

    public function renderPDF(array $valuesList = []): string
    {
        if (key_exists('value', $valuesList)) {
            return $this->view->renderFile('@fields/address__pdf.php',[
                'values' => $valuesList['value'],
                'price' => $this->getPrice($valuesList),
                'isComputed' => $this->isComputed(),
                'valute' => $this->field->form->valute->symbol,
                'title' => $this->field->name,
            ]);
            }
        return '';        
    }
}
