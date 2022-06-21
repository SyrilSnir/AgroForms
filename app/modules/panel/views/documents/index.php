<?php

use app\core\helpers\Utils\DateHelper;
use app\models\ActiveRecord\Document\Documents;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\SearchModels\Exhibition\ExhibitionSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel ExhibitionSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title','List of documents');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app', 'New document'),
                                ])                            
                        ],
                    ],    
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,    
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        return ['data-sortable-id' => $model->id];
                    },     
                    'columns' => [    
                        'title:text:' . Yii::t('app', 'Title'),
                        'description:html:' . Yii::t('app', 'Description'),                        
                        [
                            'attribute' => 'company_id',
                            'value' => 'company.name',
                            'label' => Yii::t('app/user','Company'),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => $searchModel->companiesList(),
                            'width' => '200px',
                            'filterWidgetOptions' => [
                                'options' => ['placeholder' => ''],
                            ]
                        ],
                        [
                            'attribute' => 'exhibition_id',
                            'label' => t('Exhibition'),
                            'format' => 'raw',
                            'filter' => $searchModel->getExhibitionsList(),
                            'value' => function (Documents $model) { return $model->exhibition ? $model->exhibition->title: '' ;}
                        ],
                        [
                            'label' => t('File'),
                            'attribute' => 'file',
                            'format' => 'raw',
                            'value' => function (Documents $model) {
                                return Html::a($model->file,$model->getUploadedFileUrl('file'));
                            }
                        ],
                        [
                            'label' => Yii::t('app','Date added'),
                            'attribute' => 'date',
                            'value' => function (Documents $model) {
                                /** @var Exhibition $model */
                                return DateHelper::timestampToDate($model->created_at);
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

