<?php

namespace app\core\helpers\View\Form\FormElements;

use app\models\ActiveRecord\Requests\AttachedFiles;

/**
 * Description of ElementFileInput
 *
 * @author kotov
 */
class ElementFileInput extends FormElement
{
    public function getData(array $valuesList = []): array
    {
        /** @var AttachedFiles $attached */
        $result = parent::getData($valuesList);
        $requestId = $this->getRequestId();
        if ($requestId) {
        $attached = AttachedFiles::find()
                ->andWhere(['field_id' => $result['id']])
                ->andWhere(['request_id' => $requestId])
                ->one();
        
        } else {
            $attached = null;
        }
        if ($attached) {
            $attached->configureFileUploadParameters();
            $result['file_exist'] = true;
            $result['file_url'] = $attached->getUploadedFileUrl('file_name');
            $result['file_name'] = $attached->file_name;
            $result['request_id'] = $requestId;
        } else {
            $result['file_exist'] = false;        
        }
       //if ()
        
        return $result;
    }
    
    public function renderHtml(array $valuesList = []): string
    {
        return '';
    }

    public function renderPDF(array $valuesList = []): string
    {
        return '';
    }

}
