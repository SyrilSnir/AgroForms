<?php

namespace app\core\helpers\View\Form\FormElements;

use app\core\repositories\readModels\Requests\AttachedFilesReadRepository;
use app\models\ActiveRecord\Requests\AttachedFiles;
use app\models\Forms\Manage\Forms\Parameters\AttachmentField;

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
        $fileTypeParameter = $this->getParameters('attached') ?? 0;
        $result['file_types'] = '';
        switch ($fileTypeParameter) {
            case AttachedFiles::SITE_LOGO_TYPE:
                $result['file_types'].='image/*';
            case AttachedFiles::CATALOG_LOGO_TYPE:                
                $result['file_types'].='image/jpeg,application/postscript,application/pdf';
                break;
            default:
                //$result['file_types'].='image/*';
                $result['file_types'].='image/jpeg,application/postscript,application/pdf';
                break;
        }
        
        return $result;
    }
    
    public function renderHtml(array $valuesList = []): string
    {
        /** @var AttachmentField $fieldParams */
        $fieldParams = $this->field->getFieldParams();
        $attachmentType = (int) $fieldParams->attachment;
        switch ($attachmentType) {
            case AttachedFiles::STANDART_TYPE:
                $renderedData = 'STANDART';
                break;
            case AttachedFiles::SITE_LOGO_TYPE:
                $renderedData = $this->renderLogoHtml();
                break;
            case AttachedFiles::CATALOG_LOGO_TYPE:
                $renderedData = 'CATALOG';
                break;
        }
        return "<pre>". $renderedData . "</pre>";
    }

    public function renderPDF(array $valuesList = []): string
    {
        return '';
    }
    
    protected function renderLogoHtml():string
    {   

        $result = '';
        $urls = $this->getFilesUrl();
        foreach ($urls as $url) {
            $result.= '<div class="logo-block clearfix">
                  <div class="attachment-pushed">
                    <h4 class="attachment-heading">'. $this->field->name .'</h4>

                    <!-- /.attachment-text -->
                  </div>                
                  <img class="attachment-img" src="'. $url. '" alt="Логотип">


                  <!-- /.attachment-pushed -->
                </div>';
        }
        return $result;
    }
    
    protected function getFilesUrl(): array
    {
        $result = [];
        $attachedFiles = AttachedFilesReadRepository::findByFieldId($this->field->id);
        foreach ($attachedFiles as $file) {
            $file->configureFileUploadParameters();
            $result[] = $file->getUploadedFileUrl('file_name');
        }
        return $result;
    }

}
