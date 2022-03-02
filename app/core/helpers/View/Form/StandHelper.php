<?php

namespace app\core\helpers\View\Form;

use app\core\helpers\Data\ConfigurationHelper;
use app\core\helpers\Data\StandsHelper;
use app\models\ActiveRecord\Configuration;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Requests\RequestStand;
use yii\helpers\ArrayHelper;

/**
 * Description of StandHelper
 *
 * @author kotov
 */
class StandHelper extends BaseFormHelper
{
    public function getData(bool $isReadOnly = false): array
    {
        $standsList = StandsHelper::standsList($this->form->exhibition_id);
        $formData = [
            'title' => $this->form->headerName,
            'stands' => $standsList,
            'formId' => $this->form->id,
            'userId' => $this->userId,
            'dict' => [
                        'imageInfo' => t('Approximate image of the stand','requests'),
                        'standInfo' => [
                            'space' => t('Space','requests'),  
                            'length' => t('Length','requests'),  
                            'width' => t('Width','requests'),
                            'unit' => t('m','requests')
                        ],
                        'valute' => t($this->form->valute->char_code, 'requests'),
                        'fileAttach' => [
                            'browse' => t('Browse'),
                            'selectFile' => t('Select file'),
                            'attachFile' => t('Attach file'),
                        ],            
                        'total' => [
                          'totalMsg' => t('Total','requests'),
                          'totalHead' => t('Total amount payable','requests'),
                        ],            
                        'standSize' => t('Required stand size','requests'),
                        'standLayout' => t('Stand layout','requests'),
                        'frize' => [
                            'frizeName' => t('Fascia name','requests'),
                            'symbol'  => t('symb.','requests'),
                            'name' => t('Name','requests'),
                        ],
                        'standPlan' => [
                            'header' => t('Stand plan','requests'),
                            'download' => t('Download a form \'Stand layout\'','requests'),
                            'downloadInfo' => t('Attach the plan. Also you can download a form.','requests'),
                            'attachInfo' => t('If you need more space for drawing, you can draw the plan on a separate sheet and attach it to this application.', 'requests')
                        ],
                        'buttons' => [
                          'send' => t('Send application','requests'),
                          'draft' => t('Save draft', 'requests'),
                          'cancel' => t('Cancel'),
                          'close' => t('Close'),
                        ],                
            ]
        ];
        if ($this->isRequest()) {
            if ($this->request->isRejected()) {
                $formData['needToChange'] = true;
            } else {
                $formData['needToChange'] = false;                
            }
            /** @var RequestStand $requestStand */
            $requestStand = $this->request->requestForm;
            $formData['update'] = true;
            $formData['frizeName'] = $requestStand->frize_name;
            $formData['width'] = $requestStand->width;
            $formData['length'] = $requestStand->length;
            $formData['square'] = $requestStand->square;
            $formData['standId'] = $requestStand->stand_id;
            $formData['fileName'] = $requestStand->file;
        } else {
            $formData['update'] = false;            
        }
        $standConfiguration = ConfigurationHelper::getConfig(Configuration::STAND_SETTINGS_SECTION);
        
        return ArrayHelper::merge($formData, $standConfiguration);
    }

    public function renderHtmlRequest(): string
    {
        return '';
    }

    public static function createViaForm(int $userId, string $langCode, Form $form): BaseFormHelper
    {
        $instance = new self($userId, $langCode);
        $instance->form = $form;
        return $instance;        
    }

    public static function createViaRequest(int $userId, string $langCode, Request $request): BaseFormHelper
    {
        $instance = new self($userId, $langCode);
        $instance->form = $request->form;
        $instance->request = $request;
        return $instance;        
    }

}
