<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,  
    'rules' => [
        'panel/auth' => 'panel/auth/login',
        'panel/member/<id:\d+>/requests' => 'panel/member/requests'
    ]
];
