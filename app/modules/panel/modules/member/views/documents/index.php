<?php

use app\core\helpers\Utils\DateHelper;
use app\models\ActiveRecord\Document\Documents;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\SearchModels\Exhibition\ExhibitionSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use kartik\grid\ActionColumn;
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
                                Html::a('<i class="fas fa-plus"></i>',['create','exhibitionId' => $exhibitionId], [
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
                        'title:text:' . Yii::t('app', 'Name'),
                        'description:html:' . Yii::t('app', 'Description'),                        
                        [
                            'label' => t('Filename'),
                            'attribute' => 'file',
                            'format' => 'raw',
                            'value' => function (Documents $model) {
                                return Html::a($model->file,$model->getUploadedFileUrl('file'));
                            }
                        ],
                        [
                           'class' => ActionColumn::class,                            
                            'visibleButtons' => [
                                'update' => function (Documents $model) {
                                    return !empty($model->company_id);
                                },
                                'delete' => function (Documents $model) {
                                    return !empty($model->company_id);
                                }
                            ]
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

