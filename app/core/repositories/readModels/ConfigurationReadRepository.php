<?php

namespace app\core\repositories\readModels;

use app\models\ActiveRecord\Configuration;

/**
 * Description of ConfigurationReadRepository
 *
 * @author kotov
 */
class ConfigurationReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Configuration::find($id)
            ->andWhere(['id' => $id])
            ->one();        
    }
}
