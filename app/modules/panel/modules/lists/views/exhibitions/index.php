<?php

use app\core\helpers\Utils\DateHelper;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\SearchModels\Exhibition\ExhibitionSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
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
                    'columns' => [                    
                        'title:text:' . Yii::t('app','Name'),
                        'title_eng:text:'. Yii::t('app','Name') .' (ENG)',
                        'description:text:' . Yii::t('app','Description'),
                        'description_eng:text:'. Yii::t('app','Description'). ' (ENG)',
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
                        ['class' => ActionColumn::class],
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

