<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits\Db;

use Yii;
use yii\db\DataReader;
use yii\db\Exception;

/**
 *
 * @author kotov
 */
trait QueryTrait
{
    /**
     * 
     * @param string $sql
    * @return DataReader the reader object for fetching the query result
     * @throws Exception execution failed
     */
    protected function query(string $sql) 
    {
        $link = Yii::$app->db;
        $link->open();
        $state = $link->createCommand($sql);
        return $state->query();
    }
}
