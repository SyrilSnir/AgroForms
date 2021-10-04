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
             if (!key_exists('computed', $field) || $field['computed'] == false) {
                 continue;
             }
             if ($isCheckbox && $field['checked'] == false) {
                 continue;
             }
             $formField = $this->fieldRepository->get($id);
             $unitPrice = (int) $formField->fieldParams->unitPrice;
             if ($field['equip'] != true) {
                $val = $isCheckbox ? 1 : (int) $field['value'];
                $total = $total + ($val * $unitPrice);
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
         $id = (int) $element['id'];
         $defaultValue = '';
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
        if (in_array($element['element_type_id'], ElementType::HAS_ENUM_ATTRIBUTES)) {
            /** @var Field $field */
            $field = $this->fieldRepository->get($element['id']);
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
