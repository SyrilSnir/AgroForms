<?php

namespace app\assets;

use yii\web\YiiAsset as BaseYiiAsset;

/**
 * Description of YiiAsset
 *
 * @author kotov
 */
class YiiAsset extends BaseYiiAsset
{
    public $depends = [
        MainAsset::class
    ];
}
