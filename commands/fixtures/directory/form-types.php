<?php

use app\models\ActiveRecord\Forms\FormType;

return [
    [
        'id' => FormType::SPECIAL_STAND_FORM, 
        'name' => 'Стандартный стенд',
        'description' => 'Заказ стандартного стенда'
    ],
    [
        'id' => FormType::DYNAMIC_INFORMATION_FORM, 
        'name' => 'Информационная форма'
    ],
    [
        'id' => FormType::DYNAMIC_ORDER_FORM, 
        'name' => 'Форма заказа'
    ],
];

