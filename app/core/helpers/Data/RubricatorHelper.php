<?php

namespace app\core\helpers\Data;

use app\models\ActiveRecord\Nomenclature\Rubricator;

/**
 * Description of RubricatorHelper
 *
 * @author kotov
 */
class RubricatorHelper
{
    public static function getHierarchicalList():array
    {
        $rubric = Rubricator::findOne(1);
        return $rubric->sortedList();
    }
}
