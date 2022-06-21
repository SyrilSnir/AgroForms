<?php

use app\assets\YiiAsset;
use app\core\manage\Auth\UserIdentity;
use app\models\Data\Languages;
use app\modules\panel\assets\AdminLteAsset;
use app\modules\panel\Module as ManageModule;
use kartik\base\WidgetAsset;
use kartik\bs4dropdown\DropdownAsset;
use kartik\date\DatePickerAsset;
use kartik\dialog\DialogAsset;
use kartik\dialog\DialogBootstrapAsset;
use kartik\dialog\DialogYiiAsset;
use kartik\grid\GridExportAsset;
use kartik\grid\GridViewAsset as KartikGridViewAsset;
use kartik\grid\Module;
use kartik\select2\Select2Asset;
use kartik\switchinput\SwitchInputAsset;
use lajax\languagepicker\bundles\LanguagePluginAsset;
use lajax\languagepicker\Component;
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
    'language' => Languages::RUSSIAN,
    'params' => require_once __DIR__ . '/params.php',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'panel' => [
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
                    'fileMap' => [
                        'app'       => 'app.php',
                        'app/title' => 'title.php',
                        'app/error' => 'error.php',
                        'app/user' => 'user.php',
                        'app/company' => 'company.php',
                        'app/contracts' => 'contracts.php',
                        'app/menu' => 'menu.php',
                        'app/requests' => 'requests.php',
                        'app/equipment' => 'equipment.php',
                        'app/exhibitions' => 'exhibitions.php',
                        'app/exception' => 'exception.php'
                    ],
                ],
            ],
        ],  
        'languagepicker' => [
            'class' => Component::class,
            // List of available languages (icons and text)
            'languages' => [
                Languages::ENGLISH => 'English', 
                Languages::RUSSIAN => 'Russian']
        ],        
        'formatter' => [
         //   'locale' => Languages::RUSSIAN,
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
                LanguagePluginAsset::class => [
                    'depends' => [
                        YiiAsset::class
                    ]
                ],
                JqueryAsset::class => [
                    'js'=>[]
                ],
                ActiveFormAsset::class => [
                    'depends' => [
                        YiiAsset::class
                    ]
                ],
                Select2Asset::class => [
                    'depends' => [
                        YiiAsset::class
                    ]                    
                ],
                SwitchInputAsset::class => [
                    'depends' => [
                        YiiAsset::class
                    ]                     
                ],
                GridViewAsset::class => [
                    'depends' => [
                        YiiAsset::class
                    ]
                ],
                KartikGridViewAsset::class => [
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
                WidgetAsset::class => [
                    'depends' => [
                        YiiAsset::class,
                        BootstrapAsset::class
                    ] 
                ],
                DialogYiiAsset::class => [
                    'depends' => [
                        YiiAsset::class,
                        DialogAsset::class,
                        BootstrapAsset::class                        
                    ]
                ],
                GridExportAsset::class => [
                    'depends' => [
                        YiiAsset::class,
                        DialogAsset::class,
                        BootstrapAsset::class                         
                    ]
                ],
                kartik\grid\GridResizeColumnsAsset::class => [
                    'depends' => [
                        YiiAsset::class,
                        KartikGridViewAsset::class,
                        BootstrapAsset::class                         
                    ]                    
                ],
                mihaildev\ckeditor\Assets::class => [
                    'depends' => [
                        YiiAsset::class
                    ]                    
                ],
                DatePickerAsset::class => [
                    'depends' => [
                        YiiAsset::class,
                        BootstrapAsset::class,                        
                    ]                    
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
            'defaultDuration' => 86400
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
