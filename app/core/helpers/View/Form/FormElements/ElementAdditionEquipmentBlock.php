<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\helpers\View\Form\ExcelHeaderView;
use app\core\repositories\manage\Nomenclature\EquipmentRepository;
use app\core\repositories\readModels\Nomenclature\EquipmentReadRepository;
use app\models\ActiveRecord\Nomenclature\Equipment;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Description of ElementAdditionEquipmentBlock
 *
 * @author kotov
 */
class ElementAdditionEquipmentBlock extends FormElement implements CountableElementInterface
{
    public function getLenght($equipment = false): int
    {
        $params = $this->getParameters();
        $defLenght = 0;
        $exhibitionId = $this->getField()->form->exhibition_id;
        if (key_exists('categories', $params)) {
            foreach ($params['categories'] as $categoryId) {
                $defLenght+= EquipmentReadRepository::countForExhibition($exhibitionId,$categoryId);
               // $defLenght += 1;
            }
        }
        return $defLenght;
    }

    public function getExcelHeader($equipment = true): ExcelHeaderView
    {
        $result = new ExcelHeaderView($this->getField()->name, $this->getLenght(),false,true);
        $params = $this->getParameters();
        $exhibitionId = $this->getField()->form->exhibition_id;        
        if (key_exists('categories', $params)) {
            foreach ($params['categories'] as $categoryId) {
        //         $defLenght+= EquipmentReadRepository::countForExhibition($exhibitionId,$categoryId);
                $eqList = EquipmentReadRepository::findForExhibition($exhibitionId,$categoryId);
                foreach ($eqList as $el) {
                    $result->addChild(new ExcelHeaderView($el->name,1));
                }
            }
        }        
        return $result;
    }  
    
    public function getExcelValue(array $valuesList = []): array|string
    {
        
        if (!key_exists('value', $valuesList) || empty($valuesList['value'])) {
            return [];
        }
        
        $rows = [];
        $exhibitionId = $this->getField()->form->exhibition_id;
        $eqData = ArrayHelper::map($valuesList['value'],'id','count');
        $params = $this->getParameters();
        if (key_exists('categories', $params)) {
            foreach ($params['categories'] as $categoryId) {
        //         $defLenght+= EquipmentReadRepository::countForExhibition($exhibitionId,$categoryId);
                $eqList = EquipmentReadRepository::findForExhibition($exhibitionId,$categoryId);
                foreach ($eqList as $el) {
                    if (key_exists($el->id, $eqData)) {
                        $rows[] = $eqData[$el->id];
                    } else {
                        $rows[] = '';
                    }
                }
            }
        }        
        return ['rows' => [
                0 => $rows
            ] 
        ];
    }

    private function processEquipmentValues($values)
     {
         $exhibitionId = $this->field->form->exhibition_id;
                 
         /** @var Equipment $equipment */
         $eqRepository = new EquipmentRepository();
         $resArray = [];
         $showDaleted = $this->getRequestId() ? true : false;
         foreach ($values as $value) {             
             $equipment = $eqRepository->get($value['id']);
             $price = $equipment->getExhibitionPrice($exhibitionId, $showDaleted);
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
