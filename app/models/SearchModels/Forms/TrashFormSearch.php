<?php

namespace app\models\SearchModels\Forms;

use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\Query\FormQuery;

/**
 * Description of TrashFormSearch
 *
 * @author kotov
 */
class TrashFormSearch extends FormSearch
{
    protected function getQuery(): FormQuery
    {
        return Form::find()->deleted();
    }
}
