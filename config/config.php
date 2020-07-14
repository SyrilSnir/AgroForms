<?php

use app\core\bootstrap\SetupApplication;
use yii\swiftmailer\Mailer;

return [
    'bootstrap' => [SetupApplication::class, 'log'],
    'components' => [
        'mailer' => [
            'class' => Mailer::class,
        ]
    ]
];
