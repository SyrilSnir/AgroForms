<?php

use app\core\helpers\Utils\DateHelper;
use app\core\helpers\View\Exhibition\ExhibitionStatusHelper;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\SearchModels\Exhibition\ExhibitionSearch;
use kartik\grid\GridView;
use kotchuprik\sortable\grid\Column;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel ExhibitionSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title','List of exhibitions');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app', 'New exhibition'),
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
                        'title:text:' . Yii::t('app','Name'),
                        'description:text:' . Yii::t('app','Description'),
                        [
                            'label' => Yii::t('app','Start date'),
                            'attribute' => 'start_date',
                            'value' => function (Exhibition $model) {
                                /** @var Exhibition $model */
                                return DateHelper::timestampToDate($model->start_date);
                            }
                            
                        ],
                        [
                            'label' => Yii::t('app','End date'),
                            'attribute' => 'end_date',
                            'value' => function (Exhibition $model) {
                                /** @var Exhibition $model */
                                return DateHelper::timestampToDate($model->end_date);
                            }
                            
                        ],
                        [
                            'attribute' => 'status',
                            'label' => Yii::t('app','Status'),
                            'format' => 'raw',
                            'filter' => ExhibitionStatusHelper::statusList(false),
                            'value' => function (Exhibition $model) {
                                return ExhibitionStatusHelper::getStatusLabel($model->status);
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

