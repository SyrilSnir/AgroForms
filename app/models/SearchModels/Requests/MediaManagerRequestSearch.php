<?php

namespace app\models\SearchModels\Requests;

use app\models\ActiveRecord\Requests\BaseRequest;

/**
 * Description of MediaManagerRequestSearch
 *
 * @author kotov
 */
class MediaManagerRequestSearch extends RequestSearch
{
    public function search(array $params = [])
    {
        $dp = $this->baseSearch($params);
        $dp->query->andFilterWhere(['IN', 'requests.status', [ 
                BaseRequest::STATUS_PAID, 
                BaseRequest::STATUS_NOT_PUBLICATED, 
                BaseRequest::STATUS_PUBLICATED
            ]
        ]);
        $dp->query->andFilterWhere(['published' => true]);
        return $dp;
    }
}
