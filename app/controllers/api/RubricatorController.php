<?php

namespace app\controllers\api;

use app\controllers\JsonController;
use app\models\ActiveRecord\Nomenclature\Rubricator;

/**
 * Description of RubricatorController
 *
 * @author kotov
 */
class RubricatorController extends JsonController
{
    public function actionGetList() 
    {        
        $tree = Rubricator::findOne(1)->sortedTree(false);
        return $tree;
    }
}
