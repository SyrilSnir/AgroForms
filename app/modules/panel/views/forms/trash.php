<?php

use app\core\helpers\View\Form\FormStatusHelper;
use app\core\helpers\View\YesNoStatusHelper;
use app\models\ActiveRecord\Forms\Form;
use app\models\SearchModels\Forms\FormSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use kotchuprik\sortable\grid\Column;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel FormSearch */
/* @var $dataProvider ActiveDataProvider */
/** @var Form $model */

$this->title = Yii::t('app/title','Directory of forms');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-redo"></i>', [''], [
                                    'class' => 'btn btn-outline-secondary',
                                    'title'=>t('Default sort'),
                                    'data-pjax'=> '', 
                                ]) .                            
                               Html::a('<i class="fas fa-eye"></i>', ['/panel/forms'], [
                                    'class' => 'btn btn-outline-secondary',
                                    'title'=>t('All forms'),
                                ]). 
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-success',
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
                    /*    [
                            'attribute' => 'formTypeId',
                            'label' => Yii::t('app/title','Form type'),
                            'value' => function (Form $model) {
                                return $model->formType->name;
                            }
                        ],*/
                        [
                            'attribute' => 'exhibitionId',
                            'label' => Yii::t('app/title','List of exhibitions'),
                            'format' => 'raw',
                            'filter' => $searchModel->getExhibitionsList(),
                            'value' => function (Form $model) { return $model->exhibition ? $model->exhibition->title: '' ;}
                        ],   
                        [
                            'attribute' => 'published',
                            'label' => 'Опубликована на сайте',
                            'format' => 'raw',
                            'filter' => YesNoStatusHelper::statusList(),
                            'value' => function (Form $model) {
                                return YesNoStatusHelper::getStatusLabel($model->published);
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
                            'template' => '{view} {update} {restore}',
                            'width' => '100px',   
                            'buttons' => [
                                'restore' => function ($url, $model, $key) {
                                    $title = t('Restore form','requests');
                                    $iconName = "ok-circle";
                                    $url = Url::current(['restore', 'id' => $key]);
                                    $options = [
                                        'title' => $title,
                                        'aria-label' => $title,
                                    ];                                  
                                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                                    return Html::a($icon, $url,$options);        
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
<section class="content content-large">
    <div class="card">
        <div class="card-body">
                <?= GridView::widget($fullGridConfig); ?>
        </div>
    </div>
</section>



