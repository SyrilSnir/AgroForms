<?php

namespace app\core\providers\Data\Nomenclature;

use app\models\ActiveRecord\Nomenclature\Equipment;
use yii\helpers\ArrayHelper;

/**
 * Description of EquipmentProvider
 *
 * @author kotov
 */
class EquipmentProvider
{
    public function getList(int $category = null): array
    {
        return ArrayHelper::index( Equipment::find()->with('unit')->where(['group_id' => $category])->asArray()->all(),'id');
    }
}
