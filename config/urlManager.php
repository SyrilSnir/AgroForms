<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,  
    'rules' => [
        'manage/auth' => 'manage/auth/login',
        'manage/member/<id:\d+>/requests' => 'manage/member/requests'
    ]
];
