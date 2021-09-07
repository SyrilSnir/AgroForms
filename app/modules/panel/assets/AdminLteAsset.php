<?php

namespace app\modules\panel\assets;

use app\assets\PanelAsset;
use app\assets\YiiAsset;
use yii\web\AssetBundle;

/**
 * Description of AdminLteAsset
 *
 * @author kotov
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte';
    public $css = [
        'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
        'dist/css/adminlte.min.css',
    ];
    public $js = [
      'plugins/bs-custom-file-input/bs-custom-file-input.min.js',
      'dist/js/adminlte.min.js',
    ];
    public $depends = [
        YiiAsset::class,
        PanelAsset::class
    ];
}
