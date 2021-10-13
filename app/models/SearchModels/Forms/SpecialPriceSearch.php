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
   public function search(array $params=[]): ActiveDataProvider
   {
        $query = SpecialPrice::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
        return $dataProvider;                
   }
   
    public function actionCreate()
    {
        $form = new CityForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $post = $this->service->create($form);
                return $this->redirect(['view', 'id' => $post->id]);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }    
}
