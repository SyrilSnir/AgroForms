<?php

use app\models\SearchModels\Nomenclature\RubricatorSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $searchModel RubricatorSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title','Rubricator');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app/title', 'New number'),
                                ])                            
                        ],
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [                    
                        'name:text:' . Yii::t('app','Name'),
                        'parent.name:text:' . Yii::t('app','Parent section'),
                        [
                            'class' => ActionColumn::class,
                            'visibleButtons' => [
                                'update' => false,
                                'delete' => false
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

