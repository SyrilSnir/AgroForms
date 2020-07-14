<?php

namespace app\widgets\Forms\assets;

use app\modules\manage\assets\AdminLteAsset;
use yii\web\AssetBundle;

/**
 * Description of StandWidgt
 *
 * @author kotov
 */
class StandAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'build/css/stand-form.css'
    ];                  
    public $js = [
         'build/scripts/vue.js',
         'build/scripts/stand-form.js',
    ];
    public $depends = [
        AdminLteAsset::class
        //::class
    ];    
}
