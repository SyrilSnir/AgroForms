<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Description of ManageAsset
 *
 * @author kotov
 */
class ManageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $js = [
         'build/scripts/manage.js',
    ];
    public $depends = [
        MainAsset::class
    ];
}
