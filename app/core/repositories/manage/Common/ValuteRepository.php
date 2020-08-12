<?php

namespace app\core\repositories\manage\Common;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Common\Valute;
use yii\db\ActiveRecord;

/**
 * Description of ValuteRepository
 *
 * @author kotov
 */
class ValuteRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Valute::findOne($id)) {
            throw new NotFoundException('Валюта не найдена');
        }
        return $model;
    }
}
