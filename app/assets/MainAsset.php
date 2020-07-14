<?php

namespace app\assets;

use yii\web\AssetBundle;
/**
 * Description of MainAsset
 *
 * @author kotov
 */
class MainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'build/css/main.css',
    ];
    public $js = [
         'build/scripts/manifest.js',
      //  'build/scripts/base.js',
         'build/scripts/main.js',
    ];
}
