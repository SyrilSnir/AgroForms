<?php

use app\models\ActiveRecord\Common\Valute;

return [
    [
        'id' => Valute::RUB,
        'name' => 'Рубль',
        'int_name' => 'Ruble',
        'char_code' => 'RUB',
        'symbol' => 'руб.'
    ],
    [
        'id' => Valute::USD,
        'name' => 'Доллар США',
        'int_name' => 'Dollar',
        'char_code' => 'USD',
        'symbol' => '$'        
    ],
    [
        'id' => Valute::EUR,
        'name' => 'Евро',
        'int_name' => 'Euro',
        'char_code' => 'EUR',
        'symbol' => '€'        
    ]
    
];
