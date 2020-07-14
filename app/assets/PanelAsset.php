<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Description of PanelAsset
 *
 * @author kotov
 */
class PanelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
         'build/scripts/panel.js',
    ];
}
