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
class ElementFileInput extends FormElement  implements CountableElementInterface
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
                $renderedData = $this->renderCatalogHtml($valuesList);
                break;
            case AttachedFiles::SITE_LOGO_TYPE:
                $renderedData = $this->renderLogoHtml($valuesList);
                break;
            case AttachedFiles::CATALOG_LOGO_TYPE:
                $renderedData = $this->renderCatalogHtml($valuesList);
                break;
        }
        return $renderedData;
    }

    public function renderPDF(array $valuesList = []): string
    {
        /** @var AttachmentField $fieldParams */
        $fieldParams = $this->field->getFieldParams();
        $attachmentType = (int) $fieldParams->attachment;
        switch ($attachmentType) {
            case AttachedFiles::STANDART_TYPE:
                $renderedData = $this->renderCatalogPdf($valuesList);
                break;
            case AttachedFiles::SITE_LOGO_TYPE:
                $renderedData = $this->renderLogoPdf($valuesList);
                break;
            case AttachedFiles::CATALOG_LOGO_TYPE:
                $renderedData = $this->renderCatalogPdf($valuesList);
                break;
        }
        return $renderedData;
    }

    protected function renderCatalogHtml($valuesList):string
    {   

        return $this->view->renderFile('@fields/file/other.php',[
            'fieldName' => $this->field->name,
            'price' => $this->getPrice($valuesList),
            'isComputed' => $this->isComputed(),
            'valute' => $this->field->form->valute->symbol,
            'urls' => $this->getFilesUrl()
        ]);
    }
    
    protected function renderLogoHtml($valuesList):string
    {   
        return $this->view->renderFile('@fields/file/logo.php',[
            'fieldName' => $this->field->name,
            'price' => $this->getPrice($valuesList),
            'isComputed' => $this->isComputed(),
            'valute' => $this->field->form->valute->symbol,
            'urls' => $this->getFilesUrl()
        ]);
    }
    
    protected function renderCatalogPdf($valuesList):string
    {   

        return $this->view->renderFile('@fields/file/other__pdf.php',[
            'fieldName' => $this->field->name,
            'price' => $this->getPrice($valuesList),
            'isComputed' => $this->isComputed(),
            'valute' => $this->field->form->valute->symbol,
            'urls' => $this->getFilesUrl()
        ]);
    }
    
    protected function renderLogoPdf($valuesList):string
    {   
        return $this->view->renderFile('@fields/file/logo__pdf.php',[
            'fieldName' => $this->field->name,
            'price' => $this->getPrice($valuesList),
            'isComputed' => $this->isComputed(),
            'valute' => $this->field->form->valute->symbol,
            'urls' => $this->getFilesUrl()
        ]);
    }    
    
    protected function getFilesUrl(): array
    {
        $result = [];
        if (!$this->getRequestId()) {
            return $result;
        }
        $attachedFiles = AttachedFilesReadRepository::findByFieldAndRequest($this->field->id, $this->requestId);
        foreach ($attachedFiles as $file) {
            $file->configureFileUploadParameters();
            $result[] = $file->getUploadedFileUrl('file_name');
        }
        return $result;
    }

    public function getPrice(array $valuesList = []): int
    {
        if (key_exists('value', $valuesList) && intval($valuesList['value'])) {
            return $this->modifyPrice($valuesList['value']);
        }
        return 0;       
    }
}
