<?php

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Nomenclature\Rubricator;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetRubricatorTrait
{
    public function rubricatorList()
    {
        return ArrayHelper::map(Rubricator::find()->orderBy('id')->asArray()->all(),'id','name');
    }
}
