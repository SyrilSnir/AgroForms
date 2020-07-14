<?php

namespace app\core\repositories\readModels\Companies;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Companies\Company;

/**
 * Description of CompanyReadRepository
 *
 * @author kotov
 */
class CompanyReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Company::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
