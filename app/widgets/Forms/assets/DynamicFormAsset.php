<?php

namespace app\widgets\Forms\assets;

use app\modules\manage\assets\AdminLteAsset;
use yii\web\AssetBundle;

/**
 * Description of DynamicFormAsset
 *
 * @author kotov
 */
class DynamicFormAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'build/css/dynamic-form.css'
    ];                  
    public $js = [
         'build/scripts/vue.js',
         'build/scripts/dynamic-form.js',
    ];
    public $depends = [
        AdminLteAsset::class
        //::class
    ];  
}
