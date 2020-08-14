<?php

use app\models\ActiveRecord\Common\Valute;

return [
    [
        'id' => Valute::RUB,
        'name' => 'Рубль',
        'name_eng' => 'Ruble',
        'char_code' => 'RUB',
        'symbol' => 'руб.'
    ],
    [
        'id' => Valute::USD,
        'name' => 'Доллар США',
        'name_eng' => 'Dollar',
        'char_code' => 'USD',
        'symbol' => '$'        
    ],
    [
        'id' => Valute::EUR,
        'name' => 'Евро',
        'name_eng' => 'Euro',
        'char_code' => 'EUR',
        'symbol' => '€'        
    ]
    
];
