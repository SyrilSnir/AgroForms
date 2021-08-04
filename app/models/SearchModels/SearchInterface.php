<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\SearchModels;

use yii\data\ActiveDataProvider;

/**
 *
 * @author kotov
 */
interface SearchInterface
{
    public function search(array $params): ActiveDataProvider;
}
