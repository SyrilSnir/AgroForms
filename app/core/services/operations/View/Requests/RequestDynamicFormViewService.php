<?php

namespace app\core\services\operations\View\Requests;

use app\core\repositories\manage\Forms\FieldRepository;
use app\core\repositories\manage\Nomenclature\EquipmentRepository;
use app\core\traits\Data\EquipmentValuesPrepareTrait;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\FieldEnum;
use app\models\ActiveRecord\Requests\RequestDynamicForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use function GuzzleHttp\json_decode;



/**
 * Description of RequestDynamicFormViewService
 *
 * @author kotov
 */
class RequestDynamicFormViewService
{
    use EquipmentValuesPrepareTrait;
    /**
     *
     * @var FieldRepository
     */
    private $fields;
    
    /**
     *
     * @var View
     */
    private $view;
    
    /**
     *
     * @var EquipmentRepository
     */
    private $equipmentRepository;
    
    public function __construct(FieldRepository $fields, EquipmentRepository $equipmentRepository, View $view)
    {
        $this->fields = $fields;
        $this->equipmentRepository = $equipmentRepository;
        $this->view = $view;
    }

    public function getFieldAttributes(RequestDynamicForm $requestForm): array
    {
        /** @var Field $fieldModel */
        $dopAttributes = [];
        $fields = json_decode($requestForm->fields, true);
        foreach ($fields as $id => $field) {
            $fieldModel = $this->fields->get($id);            
            if(in_array($fieldModel->element_type_id, ElementType::HAS_ENUM_VALUES)) {
                if ($fieldModel->element_type_id === ElementType::ELEMET_ADDITIONAL_EQUIPMENT) {                        
                    $valute = $requestForm->request->form->valute->char_code;
                    $value = $this->getEquipmentValues($field['value'],$valute);
                } else {
                    $value = $this->getEnumValues($id, $field['value']);
                }
 
            } else {
                $value = $field['value'];
            }
            if ($value) {
                $dopAttributes[] = [
                    'label' => $fieldModel->name,
                    'value' => $value,
                    'format' => 'raw'
                ];           
            }
        }
        return $dopAttributes;
    }
    
    public function getValuesList(RequestDynamicForm $requestForm): array
    {
        $valuesList = [];
        $fields = json_decode($requestForm->fields, true);
        foreach ($fields as $id => $field) {
            if (key_exists('value', $field)) {
                $valuesList[$id]['value'] = $field['value'];
            }
            if (key_exists('checked', $field)) {
                $valuesList[$id]['checked'] = $field['checked'];
            }
        }
        return $valuesList;
    }
    
    private function getEnumValues($fieldId, $values):string
    {
        $multiple = true;
        if (!is_array($values)) {
            $values = (int) $values;
            $multiple = false;
        }
        if (empty($values)) {
            return '';
        }
        return implode(',',ArrayHelper::getColumn(FieldEnum::find()->where(['field_id' => $fieldId])->andWhere(['value' => $values])->asArray()->all(),'name'));
    }
    
    private function getEquipmentValues(array $values,string $valute):string
    {   
        $reault = $this->processEquipmentValues($values);
        return $this->view->renderFile('@views/blocks/equipment.list.php',[
            'values' => $reault,
            'valute' => $valute
        ]);
        //return print_r($values,true);
    }    
}
