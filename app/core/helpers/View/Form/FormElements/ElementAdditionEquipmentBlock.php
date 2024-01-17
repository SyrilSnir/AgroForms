<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\repositories\manage\Nomenclature\EquipmentRepository;
use app\models\ActiveRecord\Nomenclature\Equipment;
use Yii;

/**
 * Description of ElementAdditionEquipmentBlock
 *
 * @author kotov
 */
class ElementAdditionEquipmentBlock extends FormElement implements CountableElementInterface
{
     private function processEquipmentValues($values)
     {
         $exhibitionId = $this->field->form->exhibition_id;
                 
         /** @var Equipment $equipment */
         $eqRepository = new EquipmentRepository();;
         $resArray = [];
         foreach ($values as $value) {             
             $equipment = $eqRepository->get($value['id']);
             $price = $equipment->getExhibitionPrice($exhibitionId);
             if ($price) {
                $resArray[$equipment->id] = [
                    'id' => $equipment->id,
                    'name' => $equipment->name,
                    'code' => $equipment->code,
                    'group' => $equipment->equipmentGroup->name,
                    'group_id' => $equipment->equipmentGroup->id,
                    'unit' => $equipment->unit->short_name,
                    'count' => $value['count'],
                    'price' => $this->modifyPrice($price),
                ];
             }
         }
         return $resArray;
     }
    //put your code here
    
    public function renderHtml(array $valuesList = []): string
    {
        if (!key_exists('value', $valuesList)) {
            return '';
        }
        $eqValues = $this->processEquipmentValues($valuesList['value']);
        return Yii::$app->view->renderFile('@blocks/equipment.list.php' ,[
            'values' => $eqValues,
            'fieldName' => $this->field->name,
            'valute' => $this->field->form->valute->symbol,
            'isComputed' => $this->isComputed()
        ]);
    }
    
    protected function transformData(array $fieldList, array $valuesList = []): array
    {   
        $fieldList = parent::transformData($fieldList, $valuesList);
        if (key_exists('value', $valuesList)) {
            $fieldList['value'] = $this->processEquipmentValues($valuesList['value']);
        }
        return $fieldList;
    }

    public function getPrice(array $valuesList = []): int 
    {
        $fullPrice = 0;
        if (!key_exists('value', $valuesList)) {
            return $fullPrice;
        }
        $eqValues = $this->processEquipmentValues($valuesList['value']);
        foreach ($eqValues as $element) {
            $count = $element['count'] * $element['price'];
            $fullPrice+= $count;
        }
        return $fullPrice;
    }

    public function renderPDF(array $valuesList = []): string 
    {
        if (!key_exists('value', $valuesList)) {
            return '';
        }
        $eqValues = $this->processEquipmentValues($valuesList['value']);
        return Yii::$app->view->renderFile('@blocks/equipment.list__pdf.php' ,[
            'values' => $eqValues,
            'fieldName' => $this->field->name,            
            'valute' => $this->field->form->valute->symbol,
            'isComputed' => $this->isComputed()
        ]);
    }

}
