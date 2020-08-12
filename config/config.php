<?php

use app\core\bootstrap\SetupApplication;
use yii\swiftmailer\Mailer;

return [
    'bootstrap' => [SetupApplication::class, 'log','languagepicker'],
    'components' => [
        'mailer' => [
            'class' => Mailer::class,
        ]
    ]
];
