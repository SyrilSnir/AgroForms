<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\repositories\manage;

use yii\db\ActiveRecord;
/**
 *
 * @author kotov
 */
interface RepositoryInterface
{
    public function get(int $id) :ActiveRecord;
    public function save(ActiveRecord $model) ;
    public function remove(ActiveRecord $model);
}
