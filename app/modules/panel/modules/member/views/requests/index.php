<?php

use app\core\helpers\Data\FormsHelper;
use app\core\helpers\View\Request\RequestStatusHelper;
use app\core\manage\Auth\Rbac;
use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\ActiveRecord\Requests\Request;
use app\models\SearchModels\Requests\RequestSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel RequestSearch */
/* @var $modificationsProvider ActiveDataProvider */
/** @var Request $model */
/** @var bool $isExhibitionActive */
/** @var array $availableForms */

$this->title = Yii::t('app/title','My requests');

//$formsList = FormsHelper::formsList();
//dump($formsList); die();
?>

<div class="request-view">
    <?php if ($isExhibitionActive):?>
    <p>
        <?= Html::dropDownList('requests-list', 0, $availableForms,[
            'class' => 'form-control'
        ]) ?>
        <?= Html::button(t('Add application'),[
            'id' => 'get-form-request',
            'data-contract' => $contractId,
            'class' => 'btn btn-secondary'
            ]) ?>
    </p>
    <?php endif; ?>
</div>
<div class="card full-view">
    <div class="card-body">
 <?php if (Yii::$app->session->has('success')): ?>
    <div class="alert alert-primary" role="alert">
        <?php echo Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->has('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>                                 
 <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pager' => [
                        'maxButtonCount' => 5, // максимум 5 кнопок
                        'options' => ['id' => 'mypager', 'class' => 'pagination pagination-sm'], // прикручиваем свой id чтобы создать собственный дизайн не касаясь основного.
                        'nextPageLabel' => '<i class="glyphicon glyphicon-chevron-right"></i>', // стрелочка в право
                        'prevPageLabel' => '<i class="glyphicon glyphicon-chevron-left"></i>', // стрелочка влево
                    ],
                    'filterModel' => $searchModel,
                    'columns' => [                                               [
                      'attribute' => 'form_id',
                      'label' => Yii::t('app','Form'),
                      'filter' => $searchModel->formsListForExhibition($exhibitionId),
                      'value' => 'header'
                    ],
                    /*    [
                            'attribute' => 'form',
                            'format' => 'text',
                            'label' => t('Application form'),
                        //    'filter' => $searchModel->formTypesList(),
                            'value' => function (Request $model) {
                                return $model->form->title;
                            }
                        ],*/
                        [
                            'attribute' => 'status',
                            'label' => t('Status'),
                            'format' => 'raw',
                            'filter' => RequestStatusHelper::statusList(),
                            'value' => function (Request $model) {
                                return RequestStatusHelper::getStatusLabel($model->status);
                            }
                        ],
                        'created_at:datetime:'. t('Created at'),
                        
                        [
                            'class' => ActionColumn::class,
                            'width' => '120px',
                            'hAlign' => GridView::ALIGN_LEFT,
                            'template' => '{view}{update}{change_status}{delete}&nbsp;&nbsp;&nbsp;{inform}',  
                            'buttons' => [
                                'inform' => function ($url, $model, $key) {
                            
                                        /** @var Request $model */
                                    $title = t('Information');
                                    $iconName = "info-sign color__red";
                                    $options = [
                                        'title' => $title,
                                        'aria-label' => $title,
                                        'data-toggle' => 'modal',
                                        'data-target' => '#modal-request__information',
                                        'data-request' => $model->id
                                    ];                                  
                                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                                    return Html::a($icon, ['#'],$options);                            
                                },                                
                            ],
                            'visibleButtons' => [
                                'delete' => function ($model) {
                                    /** @var Request $model */
                                    return ($model->status === BaseRequest::STATUS_DRAFT ||
                                            $model->status === BaseRequest::STATUS_REJECTED);                            
                                },
                                'update' => function ($model) {
                                    /** @var Request $model */
                                    return ($model->status === BaseRequest::STATUS_DRAFT ||
                                            $model->status === BaseRequest::STATUS_REJECTED);
                                },
                                'inform' => function ($model) {                                    
                                    /** @var Request $model */
                                    return Yii::$app->user->can(Rbac::PERMISSION_MEMBER_MENU) &&
                                            $model->isNeedToChange();
                                },                                        
                            ]                        
                        ],
                    ],
                ]); ?>
        </div>    


</div>
<?php
 Modal::begin([
     'title' => '<h3>' . t('Information from the organizer') .'</h3>',
     'options' => [
         'id' => 'modal-request__information'
     ],
     'bodyOptions' => [
         'id' => 'modal-request__content'
     ]
 ]);
Modal::end();

