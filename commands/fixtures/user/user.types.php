<?php

use app\models\ActiveRecord\Users\UserType;

return [
    [
        'id' => UserType::ROOT_USER_ID,
        'name' => 'Администратор',
        'slug' => UserType::ROOT_USER_TYPE,
    ],
    [
        'id' => UserType::MEMBER_USER_ID,
        'name' => 'Участник вычтавки',
        'slug' => UserType::MEMBER_USER_TYPE,
    ]    
];

