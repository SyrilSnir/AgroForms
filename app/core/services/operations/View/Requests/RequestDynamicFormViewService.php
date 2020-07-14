<?php

namespace app\core\services\operations\View\Requests;

use app\core\repositories\manage\Forms\FieldRepository;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Requests\RequestDynamicForm;
use function GuzzleHttp\json_decode;



/**
 * Description of RequestDynamicFormViewService
 *
 * @author kotov
 */
class RequestDynamicFormViewService
{
    /**
     *
     * @var FieldRepository
     */
    private $fields;
    
    public function __construct(FieldRepository $fields)
    {
        $this->fields = $fields;
    }

    public function getFieldAttributes(RequestDynamicForm $requestForm): array
    {
        /** @var Field $fieldModel */
        $dopAttributes = [];
        $fields = json_decode($requestForm->fields, true);
        foreach ($fields as $id => $field) {
            $fieldModel = $this->fields->get($id);
            $dopAttributes[] = [
                'label' => $fieldModel->name,
                'value' => $field['value']
            ];
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
}
