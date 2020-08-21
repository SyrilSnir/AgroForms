<?php

use app\core\bootstrap\GetActiveExhibition;
use app\core\bootstrap\SetupApplication;
use yii\swiftmailer\Mailer;

return [
    'bootstrap' => [
        'log',
        'languagepicker',        
        SetupApplication::class, 
        GetActiveExhibition::class,
    ],
    'components' => [
        'mailer' => [
            'class' => Mailer::class,
        ]
    ]
];
