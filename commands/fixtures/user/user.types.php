<?php

use app\models\ActiveRecord\Users\UserType;

return [
    [
        'id' => UserType::ROOT_USER_ID,
        'name' => 'Администратор',
        'name_eng' => 'Administrator',
        'slug' => UserType::ROOT_USER_TYPE,
    ],
    [
        'id' => UserType::MEMBER_USER_ID,
        'name' => 'Участник вычтавки',
        'name_eng' => 'Member',
        'slug' => UserType::MEMBER_USER_TYPE,
    ],
    [
        'id' => UserType::MANAGER_USER_ID,
        'name' => 'Менеджер',
        'name_eng' => 'Manager',
        'slug' => UserType::MANAGER_USER_TYPE,
    ],
    [
        'id' => UserType::ACCOUNTANT_USER_ID,
        'name' => 'Бухгалтер',
        'name_eng' => 'Accountant',
        'slug' => UserType::ACCOUNTANT_USER_TYPE,
    ]    
];

