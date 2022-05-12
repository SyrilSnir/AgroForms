<?php

namespace app\models\SearchModels\Requests;

/**
 * Description of RejectedRequestSearch
 *
 * @author kotov
 */
class RejectedRequestSearch extends ManagerRequestSearch
{
    public function search(array $params = [])
    {
        $dp = parent::search($params);
        $dp->query->rejected();
        return $dp;
    }
}
