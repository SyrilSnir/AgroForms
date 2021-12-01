<?php

namespace app\core\repositories\readModels;

use app\models\ActiveRecord\FeedbackFormModel;

/**
 * Description of FeedbackReadRepository
 *
 * @author kotov
 */
class FeedbackReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return FeedbackFormModel::find($id)
            ->andWhere(['id' => $id])
            ->one();        
    }
}
