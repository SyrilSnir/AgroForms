<?php

namespace app\core\services\Forms;

use app\core\helpers\Utils\StringHelper;
use app\core\repositories\manage\Forms\FieldRepository;
use app\core\repositories\readModels\Nomenclature\UnitReadRepository;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Nomenclature\Unit;
use function GuzzleHttp\json_decode;

/**
 * Description of FieldService
 *
 * @author kotov
 */
class FieldService
{
    /**
     *
     * @var UnitReadRepository
     */
    private $unitRepository;
    
    /**
     * FieldRepository
     * @var type 
     */
    private $fieldRepository;
    
    public function __construct(
            UnitReadRepository $unitRepository,
            FieldRepository $fieldReopsitory
            )
    {
        $this->unitRepository = $unitRepository;
        $this->fieldRepository = $fieldReopsitory;
    }
    
     public function postProcessFields(array &$fields, array $valuesList)
     {
        foreach ($fields as &$field) {
            if (array_key_exists('fields', $field)) {
                $field['isGroup'] = true;
                foreach($field['fields'] as &$element) {
                    $this->postProcessElement($element,$valuesList);                    
                }
            } else {
                $this->postProcessElement($field, $valuesList);
            }
        }          
     }
     
     public function prepareFieldsBeforeSave(string $fields):array
     {
         $fieldsArray = json_decode($fields, true);
         $resultArray = [];
         foreach ($fieldsArray as $key => $field)
         {
             $index = StringHelper::extractNumberFromString($key);
             $element = [
                            'computed' => $field['computed'],
                            'value' => $field['data']['value']
                        ];
             if (key_exists('checked', $field['data'])) {
                 $element['checked'] = $field['data']['checked'];
             }
             $resultArray[$index] = $element;
         }
         return $resultArray;
     }
     
     public function calculateTotal(array $fields, int $basePrice = 0):int
     {
         /** @var Field $formField */
         $total = $basePrice;
         foreach ($fields as $id => $field) {
             if (!key_exists('computed', $field) || $field['computed'] == false) {
                 continue;
             }
             $formField = $this->fieldRepository->get($id);
             $unitPrice = (int) $formField->fieldParams->unitPrice;
             $val = (int) $field['value'];
            $total = $total + ($val * $unitPrice);
         }         
         return $total;
     }

     private function postProcessElement(array &$element, array $valuesList)
     {
         $id = (int) $element['id'];
         /** @var Unit $unit */
        if ($element['parameters']) {
            $params = &$element['parameters'];
            $params = json_decode($params,true);
            $params['required'] = !!$params['required'];
            $params['isComputed'] = !!$params['isComputed'];
            $params['checked'] = !!$params['checked'];
            $unitId = $params['unit'] = (int) $params['unit'];
            $unit = $this->unitRepository->findById($unitId);            
            $unit ? $params['unitName'] = $unit->short_name : '';            
        }
        if (key_exists($id, $valuesList)) {
            $element['value'] = $valuesList[$id]['value'];
            if (key_exists('checked', $valuesList[$id])) {
                $element['checked'] = $valuesList[$id]['checked'];                
            }
        } else {
            $element['value'] = '';
        }
        $element['postprocess'] = true;        
     }

}
