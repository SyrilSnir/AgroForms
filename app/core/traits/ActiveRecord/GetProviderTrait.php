<?php

namespace app\core\traits\ActiveRecord;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Description of GetProviderTrait
 *
 * @author kotov
 */
trait GetProviderTrait
{
    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
    }    
}
