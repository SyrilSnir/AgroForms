<?php

namespace app\models\ActiveRecord\Forms\Query;

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
    
    public function deleted()
    {
        return $this->andWhere(['deleted' => true]);
    }    
}

