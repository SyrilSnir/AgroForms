<?php

use app\models\ActiveRecord\Exhibition\Catalog;
use app\models\SearchModels\Exhibition\CatalogSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $searchModel CatalogSearch */
/* @var $model Catalog */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title','Catalog to the site');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate                            
                        ],
                    ],    
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,    
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        return ['data-sortable-id' => $model->id];
                    },     
                    'columns' => [                      
                        [
                            'attribute' => 'exhibition_id',
                            'label' => t('Exhibition'),
                            'format' => 'raw',
                            'filter' => $searchModel->getExhibitionsList(),
                            'value' => function (Catalog $model) {
                                return $model->exhibition->title;                                
                            }
                        ],
                        'company:raw:' . t('Company','company'),
                        [
                            'label' => t('Logo for the website'),
                            'value' => function (Catalog $model) {
                                return Html::img($model->getLogoUrl(),['style' => 'width: 80px']);
                            },
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 100px'],                            
                            
                        ],
                        [
                            'attribute' => 'description',
                            'width' => '500px',
                            'label' => t('Description'),
                            'format' => 'raw'                            
                        ]
                  //      ['class' => ActionColumn::class],
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
<section class="content content-large">
    <?php if(Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-warning" role="alert"><?php echo Yii::$app->session->getFlash('error') ?></div>
    <?php endif;?>
    <?php if(Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-info" role="alert"><?php echo Yii::$app->session->getFlash('success') ?></div>
    <?php endif;?>    
    <div class="load-data-block">
        <?php $loadDataForm = ActiveForm::begin(['action' => ['catalog-load']]); ?>
        <?php echo $loadDataForm->field($catalogLoadForm, 'exhibitionId')->dropDownList($searchModel->getExhibitionsList())->label(false); ?>
        <?php echo  Html::submitButton(t('Load data'),[
             //'id' => 'form-copy',
            'class' => 'btn btn-secondary'
            ]) 
        ?>
        <?php ActiveForm::end(); ?>
    </div>    
    <div class="card">
        <div class="card-body">

                <?= GridView::widget($fullGridConfig); ?>
        </div>
    </div>
</section>

