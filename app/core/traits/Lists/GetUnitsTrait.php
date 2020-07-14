<?php
namespace app\core\traits\Lists;

use app\models\ActiveRecord\Nomenclature\Unit;
use yii\helpers\ArrayHelper;
/**
 *
 * @author kotov
 */
trait GetUnitsTrait
{
    public function unitsList()
    {
        return ArrayHelper::map(Unit::find()->orderBy('id')->asArray()->all(),'id','name');
    }    
}
