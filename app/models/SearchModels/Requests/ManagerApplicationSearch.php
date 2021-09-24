<?php

namespace app\models\SearchModels\Requests;

use app\models\ActiveRecord\Requests\BaseRequest;
use yii\data\ActiveDataProvider;


/**
 * Description of ManagerApplicationSearch
 *
 * @author kotov
 */
class ManagerApplicationSearch extends ApplicationSearch
{
    use ManagerSearchTrait;
}
