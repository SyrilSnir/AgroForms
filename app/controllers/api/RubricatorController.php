<?php

namespace app\controllers\api;

use app\controllers\JsonController;

/**
 * Description of RubricatorController
 *
 * @author kotov
 */
class RubricatorController extends JsonController
{
    public function actionGetList() 
    {
        $r = new \app\models\ActiveRecord\Nomenclature\Rubricator();
        $tree = $r->sortedTree();
        return $tree;
    }
}
