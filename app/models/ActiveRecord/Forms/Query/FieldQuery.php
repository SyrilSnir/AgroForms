<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\ActiveRecord\Forms\Query;

use yii\db\ActiveQuery;

/**
 * Description of FieldQuery
 *
 * @author kotov
 */
class FieldQuery extends ActiveQuery
{
    public function availableForForm(int $formId)
    {
        return $this->andWhere(['form_id' => $formId]);
    }
    
    public function availableInRequests() 
    {
        return $this->andWhere(['showed_in_request' => true]);
    }
}
