<?php

namespace app\models\SearchModels\Requests;

/**
 * Description of AcceptedRequestSearch
 *
 * @author kotov
 */
class AcceptedRequestSearch extends ManagerRequestSearch
{
    public function search(array $params = [])
    {
        $dp = parent::search($params);
        $dp->query->accepted();
        return $dp;
    }
}
