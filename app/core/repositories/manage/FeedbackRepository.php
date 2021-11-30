<?php

namespace app\core\repositories\manage;

use app\core\repositories\exceptions\NotFoundException;
use app\models\ActiveRecord\FeedbackFormModel;
use yii\db\ActiveRecord;

/**
 * Description of FeedbackRepository
 *
 * @author kotov
 */
class FeedbackRepository implements RepositoryInterface
{
    use DataManipulationTrait;
        
    public function get(int $id): ActiveRecord
    {
        if (!$model = FeedbackFormModel::findOne($id)) {
            throw new NotFoundException('Запись не найдена');
        }
        return $model;
    }
}
