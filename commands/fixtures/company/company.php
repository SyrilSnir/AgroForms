<?php

use app\models\ActiveRecord\Companies\BankDetail;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Companies\Contact;
use app\models\ActiveRecord\Companies\LegalAddress;
use app\models\ActiveRecord\Companies\PostalAddress;

return [
    [
        'id' => Company::BASE_COMPANY,
        'name' => 'АГРОСАЛОН',
        'full_name' => 'Выставка АГРОСАЛОН 2020',
        'inn' => '1234567890',
        'kpp' => '1234567890',
        'phone' => '1234567',
        'site' => 'www.agrosalon.ru',     
        'contacts_id' => Contact::BASE_COMPANY,
        'bank_details_id' => BankDetail::BASE_COMPANY,
        'postal_address_id' => PostalAddress::BASE_COMPANY,
        'legal_address_id' => LegalAddress::BASE_COMPANY,
    ]
];
