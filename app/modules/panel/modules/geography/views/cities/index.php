<?php

use app\core\helpers\Utils\users\RolesHelper;
use app\models\Data\Operations;
use app\models\SearchModels\Geography\CitySearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use kartik\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel CitySearch */
/* @var $dataProvider ActiveDataProvider */

?>
<section class="content">
    <div class="card">
<?php 
    $this->title = Yii::t('app/title','Directory of cities');
    $user = RolesHelper::getUser();
    $action = Yii::$app->getRequest()->getPathInfo();
    $rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
    $gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';  
    
    $toolbarContent = $rowsCountTemplate;
    if ($user->canOperation(Operations::ENTITY_COMPANY, Operations::OP_CREATE)) {
        $toolbarContent .= Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app', 'Add city'),
                                ]);
    }
    $columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $toolbarContent
                            
                        ],
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,   
                    'columns' => [                    
                        'name:text:' . Yii::t('app', 'City'),
                        [
                            'attribute' => 'region_id',
                            'label' => Yii::t('app', 'Region'),
                            'width' => '20rem',
                            'filter' => $searchModel->getRegions(),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'value' => 'region.name'                            
                        ],
                        [
                            'attribute' => 'country_id',
                            'label' => Yii::t('app', 'Country'),
                            'width' => '15rem',
                            'filter' => $searchModel->getCountries(),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'value' => 'country.name'
                        ],
                        [
                            'class' => ActionColumn::class,
                            'visibleButtons' => [
                                'delete' => $user->canOperation(Operations::ENTITY_COMPANY, Operations::OP_DELETE),
                                'updete' => $user->canOperation(Operations::ENTITY_COMPANY, Operations::OP_EDIT),
                                
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

