<?php

use app\core\helpers\Utils\DateHelper;
use app\core\helpers\View\Contract\ContractStatusHelper;
use app\models\ActiveRecord\Contract\Contracts;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\SearchModels\Contracts\ContractSearch;
use kartik\grid\GridView;
use kotchuprik\sortable\grid\Column;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel ContractSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title','Contracts list');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app', 'New contract'),
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
                            'class' => Column::class,
                        ],                        
                        'number:text:' . Yii::t('app','Number of contract'),
                        [
                            'attribute' => 'company_id',
                            'value' => 'company.name',
                            'label' => Yii::t('app/user','Company'),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => $searchModel->companiesList(),
                            'width' => '200px',
                            'filterWidgetOptions' => [
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => ['allowClear' => true],                                
                            ]
                        ],
                        [
                            'attribute' => 'exhibition_id',
                            'label' => t('Exhibition'),
                            'format' => 'raw',
                            'filter' => $searchModel->getExhibitionsList(),
                            'value' => function (Contracts $model) { return $model->exhibition ? $model->exhibition->title: '' ;}
                        ], 
                        [
                            'attribute' => 'hall_id',
                            'label' => t('Hall'),
                            'format' => 'text',
                            'filter' => $searchModel->hallsList(),
                            'filterType' => GridView::FILTER_SELECT2,                            
                            'value' => 'hall.name',
                            'width' => '100px',
                            'filterWidgetOptions' => [
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => ['allowClear' => true],                                
                            ]                            
                        ],
                        [
                            'attribute' => 'stand_number_id',
                            'label' => t('Stand`s number'),
                            'format' => 'text',
                            'filter' => $searchModel->standNumbersList(),
                            'filterType' => GridView::FILTER_SELECT2,                            
                            'value' => 'standNumber.number',
                            'width' => '150px',
                            'filterWidgetOptions' => [
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => ['allowClear' => true],                                
                            ]                            
                        ],                                
                        'stand_square:text:'. t('Stand`s square, m2'),
                        [
                            'label' => Yii::t('app','Date'),
                            'attribute' => 'date',
                            'value' => function (Contracts $model) {
                                /** @var Exhibition $model */
                                return DateHelper::timestampToDate($model->date);
                            }
                            
                        ],
                        [
                            'attribute' => 'status',
                            'label' => Yii::t('app','Status'),
                            'format' => 'raw',
                            'filter' => ContractStatusHelper::statusList(false),
                            'value' => function (Contracts $model) {
                                return ContractStatusHelper::getStatusLabel($model->status);
                            }
                        ],
                        ['class' => ActionColumn::class],
                    ], 
                    'options' => [
                        'data' => [
                            'sortable-widget' => 1,
                            'sortable-url' => Url::toRoute(['sorting']),
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

