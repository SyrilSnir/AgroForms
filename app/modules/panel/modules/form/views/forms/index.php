<?php

use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\SearchModels\Forms\FormSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel FormSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title','Directory of forms');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app', 'Add form'),
                                ])                            
                        ],
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [                        
                        'name:text:' . Yii::t('app', 'Name'),
                        'title:text:' . Yii::t('app', 'Title'),
                        [
                            'class' => ActionColumn::class,
                             'visibleButtons' => [
                                'update' => function (Form $model) {
                                    return $model->form_type_id != FormType::SPECIAL_STAND_FORM ;
                                },
                                'delete' => function (Form $model) {
                                    return $model->form_type_id != FormType::SPECIAL_STAND_FORM;
                                }
                            ]                             
                        ],
                    ],    
    ];
$gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';
$fullGridConfig = array_merge($columnsConfig,$gridConfig);                            
?>
<section class="content">
    <div class="card">
        <div class="card-body">
                <?= GridView::widget($fullGridConfig); ?>
        </div>
    </div>
</section>

