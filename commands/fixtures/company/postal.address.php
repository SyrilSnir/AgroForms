<?php

use app\models\ActiveRecord\Companies\PostalAddress;
use app\models\ActiveRecord\Geography\City;

return [
    [
        'id' => PostalAddress::BASE_COMPANY,
        'index' => '1234567',
        'city_id' => City::MOSCOW,
        'address' => 'Осенний б-р. д. 17'
    ]
];

