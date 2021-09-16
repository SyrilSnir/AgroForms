<?php

namespace app\core\services\operations\View\Requests;

use app\models\ActiveRecord\Requests\RequestStand;

/**
 * Description of RequestStandViewService
 *
 * @author kotov
 */
class RequestStandViewService
{
    public function getFieldAttributes(RequestStand $requestStand): array
    {
        return [
            [
                'label' => t('Stand type','requests'),
                'value' => $requestStand->stand->name
            ],
            [
                'label' => t('Length, m.', 'requests'),
                'value' => $requestStand->length
            ],
            [
                'label' => t('Width, m.', 'requests'),
                'value' => $requestStand->width
            ], 
            [
                'label' => t('Space, m<sup>2</sup>', 'requests'),
                'value' => $requestStand->square
            ],
            [
                'label' => t('Fascia name', 'requests'),
                'value' => $requestStand->frize_name
            ],         
            [
                'label' => t('Price','requests'),
                'value' => f($requestStand->amount) . ' ' . t($requestStand->form->valute->char_code,'requests')
            ]
        ];        
    }
}
