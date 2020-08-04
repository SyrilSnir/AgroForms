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
                'label' => 'Тип стенда',
                'value' => $requestStand->stand->name
            ],
            [
                'label' => 'Длинна, м.',
                'value' => $requestStand->length
            ],
            [
                'label' => 'Ширина, м.',
                'value' => $requestStand->width
            ], 
            [
                'label' => 'Площадь, м2',
                'value' => $requestStand->square
            ],
            [
                'label' => 'Фризовая надпись',
                'value' => $requestStand->frizeName
            ],         
            [
                'label' => 'Стоимость',
                'value' => $requestStand->amount . ' USD'
            ]
        ];        
    }
}
