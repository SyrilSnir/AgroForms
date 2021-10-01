<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\core\traits;

use app\models\Forms\RowsCountForm;
use app\models\SearchModels\SearchInterface;
use Yii;
use yii\helpers\Url;

/**
 *
 * @author kotov
 */
trait GridViewTrait
{
    /**
     * 
     * @var SearchInterface
     */
    private $searchModel;
    
    /**
     * 
     * @var bool Показ постраничной навигации
     */
    private $showPagination = true;
    
    public function actionIndex() 
    {
        Url::remember();
        $dataProvider = $this->searchModel->search(Yii::$app->request->queryParams);
        if ($this->showPagination) {
            $rowsCountForm = new RowsCountForm();        
            if (!($rowsCountForm->load(Yii::$app->request->get()) && $rowsCountForm->validate())) {       
                $rowsCountForm->rowsCount = RowsCountForm::DEFAULT_ROWS_COUNT;
            }   
            $dataProvider->pagination = ['pageSize' => $rowsCountForm->rowsCount];
        }
        return $this->render('index',[            
            'searchModel' => $this->searchModel,
            'dataProvider' => $dataProvider,
            'rowsCountForm' => $rowsCountForm,
            'pagination' => $this->showPagination
        ]);
    }    
    
}
