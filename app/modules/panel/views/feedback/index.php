<?php

use app\models\SearchModels\FeedbackSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\web\View;
/* @var $this View */
/* @var $searchModel FeedbackSearch */
/* @var $dataProvider ActiveDataProvider */
?>
<section class="content">
    <div class="card">
<?php 
    $this->title = Yii::t('app/menu','Feedback');
    $action = Yii::$app->getRequest()->getPathInfo();
    $rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
    $gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';  
    $columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate                          
                        ],
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,   
                    'columns' => [                    
                        [
                            'attribute' => 'fio',
                            'label' => Yii::t('app/user', 'Full name'),
                            'width' => '20rem',
                           // 'filter' => $searchModel->getRegions(),
                          //  'filterType' => GridView::FILTER_SELECT2,
                         /*   'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'pluginOptions' => ['allowClear' => true],
                            ],*/
                            'value' => 'user.fio'                            
                        ],
                        [
                          'attribute' => 'message',
                          'value' => 'message',
                          'width' => '25rem',
                          'label' => Yii::t('app', 'Message'),
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => 'created_at',
                            'format' => 'datetime',
                            'label' => Yii::t('app','Date and time')
                            
                        ],
                        [
                            'class' => ActionColumn::class,
                            'visibleButtons' => [
                                'update' => false
                            ]
                        ],
                    ],        
        ];
    $fullGridConfig = array_merge($columnsConfig,$gridConfig);    
    
 ?>
        <div class="card-body">
<?= GridView::widget($fullGridConfig); ?>
        </div>
    </div>
</section>