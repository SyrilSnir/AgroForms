<?php

use app\models\SearchModels\Geography\RegionSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel RegionSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title', 'Directory of regions');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app/company', 'Add company'),
                                ])                            
                        ],
                    ],
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,    
                    'columns' => [                    
                        'name:text:' . Yii::t('app','Region'),
                        [
                            'attribute' => 'country_id',
                            'label' => Yii::t('app', 'Country'),
                            'width' => '15rem',
                            'filter' => $searchModel->countriesList(),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'value' => 'country.name'
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

