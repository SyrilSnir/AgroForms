<?php

use app\assets\YiiAsset;
use app\core\manage\Auth\UserIdentity;
use app\modules\manage\assets\AdminLteAsset;
use app\modules\manage\Module as ManageModule;
use kartik\bs4dropdown\DropdownAsset;
use kartik\dialog\DialogAsset;
use kartik\dialog\DialogBootstrapAsset;
use kartik\grid\GridViewAsset as GridViewAsset2;
use kartik\grid\Module;
use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use yii\caching\FileCache;
use yii\grid\GridViewAsset;
use yii\log\FileTarget;
use yii\rbac\PhpManager;
use yii\validators\ValidationAsset;
use yii\web\JqueryAsset;
use yii\widgets\ActiveFormAsset;

return [
    'id' => 'agroforms',
    'name' => 'Агросалон. Управление заявками.',
    'basePath' => realpath(__DIR__ .'/../'),
    'version' => '0.0',
    'viewPath' => '@views',
    'language' => 'ru-Ru',
    'params' => require_once __DIR__ . '/params.php',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'manage' => [
            'class' => ManageModule::class,
            'layout' => 'main',
            'defaultRoute' => 'main/index',
        ],
        'gridview' =>  [
           'class' => Module::class
        ]
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php',
                        'app/user' => 'user.php',
                        'app/company' => 'company.php',
                    ],
                ],
            ],
        ],  
        'languagepicker' => [
            'class' => 'lajax\languagepicker\Component',
            // List of available languages (icons and text)
            'languages' => ['en' => 'English', 'ru-RU' => 'Russian']
        ],        
        'formatter' => [
            'locale' => 'ru-RU',
            'thousandSeparator' => ' ',
            'defaultTimeZone' => 'Europe/Moscow',
            'timeZone' => 'Europe/Moscow',
            'dateFormat' => 'dd.MM.yyyy',
            'timeFormat' => 'HH:mm:ss',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm:ss',
        ],       
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                JqueryAsset::class => [
                    'js'=>[]
                ],
                ActiveFormAsset::class => [
                    'depends' => [
                        YiiAsset::class
                    ]
                ],
                kartik\select2\Select2Asset::class => [
                    'depends' => [
                        YiiAsset::class
                    ]                    
                ],
                GridViewAsset::class => [
                    'depends' => [
                        YiiAsset::class
                    ]
                ],
                GridViewAsset2::class => [
                    'depends' => [
                        YiiAsset::class
                    ]                    
                ],
                ValidationAsset::class => [
                    'depends' => [
                        YiiAsset::class
                    ]
                ],
                DialogAsset::class => [
                    'depends' => [
                        AdminLteAsset::class
                    ]
                ],
                DialogBootstrapAsset::class => [
                    'depends' => [
                        AdminLteAsset::class
                    ]
                ],
                BootstrapAsset::class => [
                     'js'=>[],
                     'css'=>[],
                     'depends'=>[],
                ],
                BootstrapPluginAsset::class => [
                     'js'=>[],
                     'css'=>[],
                     'depends'=>[],                    
                ],
                DropdownAsset::class => [
                    'depends' => [
                        AdminLteAsset::class
                    ]
                ]
            ],
        ],
        'authManager' => [
            'class' => PhpManager::class,
        ],
        'request' => [
            'cookieValidationKey' => 'RYJTYJTUKJTYTGYUDJFАYKUU',
            'baseUrl' => '',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'user' => [
            'identityClass' => UserIdentity::class,
            'enableAutoLogin' => false,
        //    'loginUrl' => ['adminka/login'],
        ],
        'cache' => [
            'class' => FileCache::class,
        ],        
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning','info'],
                    'logVars' => ['_GET', '_POST'],
                ],
            ],
        ],
        
    ],
];
