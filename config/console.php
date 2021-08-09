<?php

use yii\caching\FileCache;
use yii\log\FileTarget;
use yii\rbac\PhpManager;

if (YII_DEBUG) {
    $db = require __DIR__ . '/db-dev.php';
} else {
    $db = require __DIR__ . '/db.php';
}


$config = [
    'id' => 'bfree-console',
    'basePath' => realpath(__DIR__ .'/../'),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'authManager' => [
            'class' => PhpManager::class,
        ],
    ],
    'params' => require_once __DIR__ . '/params.php',
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];
return $config;

