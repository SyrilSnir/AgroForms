<?php

namespace app\core\repositories\readModels\Common;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Common\Valute;

/**
 * Description of ValuteReadRepository
 *
 * @author kotov
 */
class ValuteReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Valute::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
}
