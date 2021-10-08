<?php

use app\core\helpers\View\Form\FormStatusHelper;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\SearchModels\Forms\FormSearch;
use kartik\grid\GridView;
use kotchuprik\sortable\grid\Column;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel FormSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title','Directory of forms');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> 
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app', 'Add form'),
                                ])                            
                        ],
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        return ['data-sortable-id' => $model->id];
                    }, 
                    'columns' => [  
                        [
                            'class' => Column::className(),
                        ],                        
                        'name:text:' . Yii::t('app', 'Name'),
                        'title:text:' . Yii::t('app', 'Title'),
                        [
                            'attribute' => 'exhibitions',
                            'label' => Yii::t('app/title','List of exhibitions'),
                            'format' => 'raw',
                            'filter' => $searchModel->getExhibitionsList(),
                            'value' => function (Form $model) {
                                $exhibitionStr = '';
                                foreach ($model->exhibitions as $exhibition) {
                                    $exhibitionStr.= "<pre>{$exhibition->title}</pre>";
                                }
                                return $exhibitionStr;
                            }
                        ],                        
                        [
                            'attribute' => 'status',
                            'label' => Yii::t('app','Status'),
                            'format' => 'raw',
                            'filter' => FormStatusHelper::statusList(false),
                            'value' => function (Form $model) {
                                return FormStatusHelper::getStatusLabel($model->status);
                            }
                        ],                         
                        [
                            'class' => ActionColumn::class,
                             'visibleButtons' => [
                                'update' => function (Form $model) {
                                    return $model->form_type_id != FormType::SPECIAL_STAND_FORM ;
                                },
                                'delete' => function (Form $model) {
                                    return $model->form_type_id != FormType::SPECIAL_STAND_FORM;
                                }
                            ]                             
                        ],
                    ],  
                    'options' => [
                        'data' => [
                            'sortable-widget' => 1,
                            'sortable-url' => Url::toRoute(['forms-sorting']),
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

