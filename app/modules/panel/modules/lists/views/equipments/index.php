<?php
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\SearchModels\Nomenclature\EquipmentSearch;

/* @var $this yii\web\View */
/* @var $searchModel EquipmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/title','Directory of add. equipments');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app/title','New equipment'),
                                ])                            
                        ],
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [                    
                        'name:text:' . Yii::t('app','Name'),
                        [
                            'attribute' => 'code',
                            'value' => 'code',
                            'label' => Yii::t('app','Code'),
                            'width' => '75px',                            
                        ],                        
                        [
                            'attribute' => 'description',
                            'value' => 'description',
                            'label' => Yii::t('app','Description'),
                            'width' => '350px',                            
                        ],
                        [
                            'attribute' => 'group_id',
                            'value' => 'equipmentGroup.name',
                            'label' => Yii::t('app','Category'),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => $searchModel->categoriesList(),
                            'width' => '200px',
                            'filterWidgetOptions' => [
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => ['allowClear' => true],                                
                            ]
                        ],
                        [
                            'attribute' => 'unit_id',
                            'value' => 'unit.name',
                            'label' => Yii::t('app','Unit'),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => $searchModel->unitsList(),
                            'width' => '150px',
                            'filterWidgetOptions' => [
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => ['allowClear' => true],                                
                            ]
                        ],                        
                       // 'unit.name:text:' . Yii::t('app','Unit'),
                        ['class' => ActionColumn::class],
                    ],
                ];
$gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';
$fullGridConfig = array_merge($columnsConfig,$gridConfig);

?>
<section class="content content-large">
    <div class="card">
        <div class="card-body">
                <?= GridView::widget($fullGridConfig); ?>
        </div>
    </div>
</section>

