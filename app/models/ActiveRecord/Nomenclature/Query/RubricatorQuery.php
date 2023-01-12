<?php

namespace app\models\ActiveRecord\Nomenclature\Query;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

/**
 * Description of RubricatorQuery
 *
 * @author kotov
 */
class RubricatorQuery extends ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::class,
        ];
    }
}
