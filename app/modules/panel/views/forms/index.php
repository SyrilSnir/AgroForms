<?php

use app\core\helpers\View\Form\FormStatusHelper;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\SearchModels\Forms\FormSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use kotchuprik\sortable\grid\Column;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel FormSearch */
/* @var $dataProvider ActiveDataProvider */
/** @var Form $model */

$this->title = Yii::t('app/title','Directory of forms');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> 
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app', 'Add form'),
                                ])                            
                        ],
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        return ['data-sortable-id' => $model->id];
                    }, 
                    'columns' => [  
                        [
                            'class' => Column::className(),
                        ],                        
                        'name:text:' . Yii::t('app', 'Name'),
                        'title:text:' . Yii::t('app', 'Title'),
                        [
                            'attribute' => 'exhibitionId',
                            'label' => Yii::t('app/title','List of exhibitions'),
                            'format' => 'raw',
                            'filter' => $searchModel->getExhibitionsList(),
                            'value' => function (Form $model) { return $model->exhibition->title ;}
                        ],                        
                        [
                            'attribute' => 'status',
                            'label' => Yii::t('app','Status'),
                            'format' => 'raw',
                            'filter' => FormStatusHelper::statusList(false),
                            'value' => function (Form $model) {
                                return FormStatusHelper::getStatusLabel($model->status);
                            }
                        ],                         
                        [
                            'class' => ActionColumn::class,                           
                        ],
                    ],  
                    'options' => [
                        'data' => [
                            'sortable-widget' => 1,
                            'sortable-url' => Url::toRoute(['forms-sorting']),
                        ]
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

