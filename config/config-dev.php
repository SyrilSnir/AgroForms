<?php

use app\core\bootstrap\GetActiveExhibition;
use app\core\bootstrap\SetupApplication;
use yii\debug\Module;
use yii\gii\Module as GiiModule;
use yii\swiftmailer\Mailer;

return [
    'bootstrap' => [
        'languagepicker',
        SetupApplication::class, 
        GetActiveExhibition::class,
        'log',
        'debug',
        'gii',
    ],
    'modules' => [
        'gii' => [
            'class' => GiiModule::class,
            // uncomment the following to add your IP if you are not connecting from localhost.
            //'allowedIPs' => ['127.0.0.1', '::1'],
            ],
        'debug' => [
        'class' => Module::class,
        // uncomment and adjust the following to add your IP if you are not connecting from localhost.
         'allowedIPs' => ['127.0.0.1', '::1','149.126.169.175'],
        ],
    ],
    'components' => [
        'mailer' => [
            'class' => Mailer::class,
        ]
    ]
];
