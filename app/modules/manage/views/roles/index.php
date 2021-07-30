<?php

use app\models\SearchModels\Users\UserTypeSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\View;

/* @var $this View */
/* @var $searchModel UserTypeSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app', 'User roles');
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [ 
    'toolbar' => [
        [
            'content'=> $rowsCountTemplate
        ],
    ],                    
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [                    
        'name:text:' . Yii::t('app','Name'),
        'slug:text:' . Yii::t('app','Identifier'),
        [
            'class' => ActionColumn::class,
            'width' => '100px',            
            'visibleButtons' => [
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

