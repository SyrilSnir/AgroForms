<?php

use app\models\ActiveRecord\Companies\LegalAddress;
use app\models\ActiveRecord\Geography\City;

return [
    [
        'id' => LegalAddress::BASE_COMPANY,
        'index' => '1234567',
        'city_id' => City::MOSCOW,
        'address' => 'Осенний б-р. д. 17'
    ]
    
];

