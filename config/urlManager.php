<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,  
    'rules' => [
        'panel/auth' => 'panel/auth/login',
        'panel/member/<exhibitionId:\d+>/requests/<contractId:\d+>' => 'panel/member/requests',
        'panel/member/<exhibitionId:\d+>/documents' => 'panel/member/documents',
        'panel/manager/companies' => 'panel/companies'
    ]
];
