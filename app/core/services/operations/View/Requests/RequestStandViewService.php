<?php

namespace app\core\services\operations\View\Requests;

use app\models\Forms\Requests\StandForm;

/**
 * Description of RequestStandViewService
 *
 * @author kotov
 */
class RequestStandViewService
{
    public function getFieldAttributes(StandForm $requestForm): array
    {
        return [
            [
                'label' => 'Тип стенда',
                'value' => $requestForm->stand->name
            ],
            [
                'label' => 'Длинна, м.',
                'value' => $requestForm->length
            ],
            [
                'label' => 'Ширина, м.',
                'value' => $requestForm->width
            ], 
            [
                'label' => 'Площадь, м2',
                'value' => $requestForm->square
            ],
            [
                'label' => 'Фризовая надпись',
                'value' => $requestForm->frizeName
            ],         
            [
                'label' => 'Стоимость',
                'value' => $requestForm->amount . ' USD'
            ]
        ];        
    }
}
