<?php

namespace app\models\SearchModels\Requests;

/**
 * Description of NewRequestSearch
 *
 * @author kotov
 */
class NewRequestSearch extends ManagerRequestSearch
{
    public function search(array $params = [])
    {
        $dp = parent::search($params);
        $dp->query->new();
        return $dp;
    }
}
