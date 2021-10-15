<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\SearchModels\Forms;

use app\models\ActiveRecord\Forms\SpecialPrice;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Description of SpecialPriceSearch
 *
 * @author kotov
 */
class SpecialPriceSearch extends Model
{  
   public function functionName()
   {
       
   }
   public function search(int $fieldId): ActiveDataProvider
   {
        $query = SpecialPrice::find()
                ->andWhere(['field_id' => $fieldId]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
        return $dataProvider;                
   }  
}
