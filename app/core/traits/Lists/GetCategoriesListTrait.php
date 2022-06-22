<?php

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Nomenclature\EquipmentGroup;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetCategoriesListTrait 
{
    public function categoriesList()
    {
        return ArrayHelper::map(EquipmentGroup::find()->orderBy('id')->asArray()->all(), 'id', 'name');
    }    
}
