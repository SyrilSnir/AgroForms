<?php

namespace app\models\ActiveRecord\Forms\Query;

use app\models\ActiveRecord\Forms\Form;
use yii\db\ActiveQuery;

/**
 * Description of FormQuery
 *
 * @author kotov
 */
class FormQuery extends ActiveQuery
{
    public function actual()
    {
        return $this->andWhere(['deleted' => false]);        
    }
    
    public function active()
    {
        return $this->andWhere(['status' => Form::STATUS_ACTIVE]);
    }
    
    public function deleted()
    {
        return $this->andWhere(['deleted' => true]);
    }

    public function byExgibition(int $exhibitionId)
    {
        return $this->andWhere(['exhibition_id' => $exhibitionId]);
    }
}

