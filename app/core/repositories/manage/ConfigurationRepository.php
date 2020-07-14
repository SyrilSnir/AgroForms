<?php

namespace app\core\repositories\manage;

use app\core\repositories\exceptions\NotFoundException;
use app\models\ActiveRecord\Configuration;
use yii\db\ActiveRecord;

/**
 * Description of ConfigurationRepository
 *
 * @author kotov
 */
class ConfigurationRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Configuration::findOne($id)) {
            throw new NotFoundException('Услуга не найдена');
        }
        return $model;
    }
    
    public function findByAttribute(string $section, string $attribute)
    {
        return Configuration::find()
                ->andWhere(['section' => $section])
                ->andWhere(['name' => $attribute])
                ->one();
    }
}
