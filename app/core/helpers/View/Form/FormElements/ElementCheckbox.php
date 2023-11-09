<?php

namespace app\core\helpers\View\Form\FormElements;

/**
 * Description of ElementCheckbox
 *
 * @author kotov
 */
class ElementCheckbox extends FormElement implements CountableElementInterface
{    
    public function renderHtml(array $valuesList = []): string
    {
        if (!key_exists('checked', $valuesList) || !$valuesList['checked']) {
            return '';
        }
        return $this->view->renderFile('@fields/checkbox.php',[
            'fieldName' => $this->field->name,
            'valuesList' => $valuesList,
            'checkbox' => $this,
            'valute' => $this->field->form->valute->symbol,
            'hasComment' => key_exists('hasCommentField', $valuesList) ? !!$valuesList['hasCommentField'] :
            false,
            'comment' => $valuesList['comment'] ?? false
        ]);
    }
    
    protected function transformData(array $fieldList, array $valuesList = []): array
    {    
        $fieldList = parent::transformData($fieldList, $valuesList);
        if (!empty($valuesList) && key_exists('checked', $valuesList)) {
            $fieldList['value'] = $valuesList['value'];
            $fieldList['checked'] = $valuesList['checked'];
            $fieldList['hasCommentField'] = key_exists('hasCommentField', $valuesList) ?
                    $valuesList['hasCommentField'] : false;
            $fieldList['comment'] = $valuesList['comment'] ?? false;
        }
        return $fieldList;
    }

    public function getPrice(array $valuesList = []): int 
    {
        if (!key_exists('checked', $valuesList) || !$valuesList['checked']) {
            return 0;
        }
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
            return $this->modifyPrice($valuesList['value']);
        }
        return 0;
    }

    public function renderPDF(array $valuesList = []): string 
    {        
        if (key_exists('checked', $valuesList) && $valuesList['checked'] == true) {
            if (key_exists('value', $valuesList) && $valuesList['value'] > 0) {
                $text = '<tr style="border:none;border-bottom:1px solid #ededed"><td style="color:black;font-family:Verdana;font-size: 10pt;font-weight:bold;text-align:left;">' . $this->field->name .  ': </td>'; 
                $text .= '<td style="color:black;font-family:Verdana;font-size:10pt;font-weight:bold;text-align:right;">' . $this->modifyPrice($valuesList['value']) . ' '. $this->field->form->valute->symbol . '</td>';
            } else {
                $text = '<tr style="color:black;font-family:Verdana;border:none;border-bottom:1px solid #ededed"><td colspan="2" style="font-family:Verdana;font-size:10pt;font-weight:bold;text-align:left;">' . $this->field->name .  ': </td>';
            }
                if ($valuesList['hasCommentField'] && !empty($valuesList['comment'])) {
                    $text.= '</tr><tr><td style="color:black;font-family:Verdana;font-size:8pt;font-weight:lighten;text-align:right;">' .
                            $valuesList['comment'] . '</td>';
                }            
            return $text . '</tr>';
        }
        return '';
    }   
}
