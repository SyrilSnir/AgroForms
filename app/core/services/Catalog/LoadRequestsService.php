<?php

namespace app\core\services\Catalog;

use app\core\helpers\View\Form\BaseFormHelper;
use app\core\helpers\View\Form\FormHelper;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Manage\Exhibition\CatalogForm;
use yii\helpers\ArrayHelper;

/**
 * Description of LoadRequestsService
 *
 * @author kotov
 */
class LoadRequestsService
{
    /**
     * 
     * @var FormHelper[]
     */
    protected $formHelpers = [];
    
    /**
     * 
     * @var string
     */
    protected $langCode = '';

    
    public function getCatalogForms(array $requests) :array
    {
        $forms = [];
        $this->langCode = $this->langCode;        
        $this->initHelpers($requests);        
        $catalogData = [];
        foreach ($this->formHelpers as $formHelper) {
            $request = $formHelper->getRequest();
            $exhibitionId = $request->form->exhibition_id;
            $result = $formHelper->getCatalogData();
            if (!empty($result)) {
                $form = new CatalogForm();                
                $catalogData = $this->modifyData($result);
                $catalogData['requestId'] = $request->id;
                $catalogData['exhibitionId'] = $exhibitionId; 
                $catalogData['stand'] = $request->contract->standNumber->number;
                $form->setAttributes($catalogData);
                if ($form->validate()) {
                    array_push($forms, $form);
                }
                
            }
        }
        return $forms;
    }

    /**
     * 
     * @param Request[] $requests
     */
    public function initHelpers(array $requests)
    {
        foreach ($requests as $request) 
        {
            $this->formHelpers[] = FormHelper::createViaRequest(
                    $request->user,
                    $request->contract, 
                    $this->langCode, 
                    $request);
        }
    }
    
    protected function modifyData(array $data)
    {
        $result = [];
        foreach ($data as $element) {
            switch ($element['label'])
            {
                case BaseFormHelper::COMPANY_NAME_RUS:
                    $result['company'] = $element['value'];
                    break;
                case BaseFormHelper::COMPANY_NAME_ENG:
                    $result['companyEng'] = $element['value'];
                    break;
                case BaseFormHelper::COMPANY_INFORMATION_RUS:
                    $result['description'] = $element['value'];
                    break;
                case BaseFormHelper::COMPANY_INFORMATION_ENG:
                    $result['descriptionEng'] = $element['value'];
                    break;
                case BaseFormHelper::COMPANY_ADDRESS_RUS:
                    $result['country'] = $this->getCountryIds($element['value']);
                    break;
                case BaseFormHelper::COMPANY_ADDRESS_ENG:
                    $result['countryEng'] = $this->getCountryIds($element['value']);
                    break;  
                case BaseFormHelper::SITE_LOGO:
                    $result['logoFile'] = $element['file'];
                    break;                  
                case BaseFormHelper::RUBRICATOR:
                    $result['rubricatorIds'] = $this->getRubricatorIds($element['value']);
                    break;
            }
        }
        return $result;
    }
    /**
     * 
     */
    private function getRubricatorIds(array $data): array
    {
        if (!empty($data)) {
            return ArrayHelper::getColumn($data, 'id');
        }
        return [];
    }
    
    private function getCountryIds(array $data): array
    {
        if (!empty($data)) {
            return ArrayHelper::getColumn($data, function($element) { return (int)$element['country']; });
        }
        return [];
    }    
}
