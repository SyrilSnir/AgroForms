<?php

namespace app\core\services\Forms;

use app\core\helpers\Utils\StringHelper;
use app\core\providers\Data\FieldEnumProvider;
use app\core\repositories\manage\Forms\FieldRepository;
use app\core\repositories\manage\Nomenclature\EquipmentRepository;
use app\core\repositories\readModels\Nomenclature\UnitReadRepository;
use app\core\traits\Data\EquipmentValuesPrepareTrait;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\FieldEnum;
use app\models\ActiveRecord\Nomenclature\Unit;
use function GuzzleHttp\json_decode;

/**
 * Description of FieldService
 *
 * @author kotov
 */
class FieldService
{
    use EquipmentValuesPrepareTrait;
    /**
     *
     * @var UnitReadRepository
     */
    private $unitRepository;
    
    /**
     *
     * @var  FieldRepository
     */
    private $fieldRepository;

    /**
     *
     * @var FieldEnumProvider
     */
    private $fieldEnumProvider;
    
    /**
     *
     * @var EquipmentRepository
     */
    private $equipmentRepository;


    public function __construct(
            UnitReadRepository $unitRepository,
            FieldRepository $fieldReopsitory,
            FieldEnumProvider $fieldEnumProvider,
            EquipmentRepository $equipmentRepository
            )
    {
        $this->unitRepository = $unitRepository;
        $this->fieldRepository = $fieldReopsitory;
        $this->fieldEnumProvider = $fieldEnumProvider;
        $this->equipmentRepository = $equipmentRepository;
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
             if (!key_exists('value', $field['data'])) {
                 $field['data']['value'] = null;
             }
             $index = StringHelper::extractNumberFromString($key);             
             $element = [
                            'computed' => $field['computed'],
                            'value' => $field['data']['value']
                        ];
             $element['checkbox'] = $field['checkbox'];
             $element['equip'] = $field['equip'];
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
             $isCheckbox = $field['checkbox'];
             $field['checked'] ??= false;
             $field['computed'] ??= false;
             if (!$field['computed']) {
                 continue;
             }
             if ($isCheckbox && $field['checked'] == false) {
                 continue;
             }
             $formField = $this->fieldRepository->get($id);
            if (!$formField->fieldParams->unitPrice) {
               $unitPrice = 0;
            } else {
                $unitPrice = (int) $formField->price;
            }
             if ($field['equip'] != true) {
                 if ($formField->element_type_id === ElementType::ELEMENT_SELECT_MULTIPLE) {
                     foreach ($field['value'] as $element) {
                         /** @var FieldEnum $fieldEnum */
                         $fieldEnum = FieldEnum::findOne($element);
                         if ($fieldEnum && floatval($fieldEnum->value)) {                             
                            $total+= $unitPrice * $fieldEnum->value;
                         }
                     }
                 } elseif (in_array($formField->element_type_id, [ElementType::ELEMENT_SELECT, ElementType::ELEMENT_RADIO_BUTTON])) {
                         $fieldEnum = FieldEnum::findOne($field['value']);  
                         if ($fieldEnum && floatval($fieldEnum->value)) {                             
                            $total+= $unitPrice * $fieldEnum->value;
                         }                         
                 } else {
                    $val = $isCheckbox ? 1 : (int) $field['value'];
                    $total = $total + ($val * $unitPrice);
                 }
             } else {
                 foreach ($field['value'] as $element) {
                     $total = $total + ($element['price'] * $element['count']);
                 }                 
             }
         }         
         return $total;
     }

     private function postProcessElement(array &$element, array $valuesList)
     {
            /** @var Field $field */
         $id = (int) $element['id'];
         $defaultValue = '';
         $field = $this->fieldRepository->get($id);
         /** @var Unit $unit */
        if ($element['parameters']) {
            $params = &$element['parameters'];
            $params = json_decode($params,true);
            $params['required'] = array_key_exists('required', $params) ? !!$params['required'] : false;
            $params['isComputed'] = array_key_exists('isComputed', $params) ? !!$params['isComputed'] : false;
            $params['checked'] = array_key_exists('checked', $params) ? !!$params['checked'] : false;
            $unitId = $params['unit'] = array_key_exists('unit', $params) ? (int) $params['unit'] : null;
            if ($unitId) {
                $unit = $this->unitRepository->findById($unitId);            
                $unit ? $params['unitName'] = $unit->short_name : '';
            }
            $params['unitPrice'] = $field->price;
        }
        if (in_array($element['element_type_id'], ElementType::HAS_ENUM_ATTRIBUTES)) {
            $element['enumsList'] = $this->fieldEnumProvider->getEnumsList($field);
            if (count($element['enumsList']) > 0) {
                $defaultValue = $element['enumsList'][0]['value'];
            }
        }
        
        if (key_exists($id, $valuesList)) {
            $value = $valuesList[$id]['value'];
            if($element['element_type_id'] == ElementType::ELEMET_ADDITIONAL_EQUIPMENT) {
                $value = $this->processEquipmentValues($value);
            }            
            $element['value'] = $value;
            if (key_exists('checked', $valuesList[$id])) {
                $element['checked'] = $valuesList[$id]['checked'];                
            }
        } else {
            $element['value'] = $defaultValue;
        }
        $element['postprocess'] = true;        
     }    
}
