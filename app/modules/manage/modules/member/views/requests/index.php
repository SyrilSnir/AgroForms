<?php

use app\core\helpers\Data\FormsHelper;
use app\core\helpers\View\Request\RequestStatusHelper;
use app\models\ActiveRecord\Requests\Request;
use app\models\SearchModels\Requests\RequestSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel RequestSearch */
/* @var $modificationsProvider ActiveDataProvider */
/** @var Request $model */
/** @var bool $isExhibitionActive */

$this->title = $model->name;

//$formsList = FormsHelper::formsList();
//dump($formsList); die();
?>

<div class="request-view">
    <?php if ($isExhibitionActive):?>
    <p>
        <?= Html::dropDownList('requests-list', 0, FormsHelper::formsList(),[
            'class' => 'form-control'
        ]) ?>
        <?= Html::button(t('Add application'),[
            'id' => 'get-form-request',
            'class' => 'btn btn-secondary'
            ]) ?>
    </p>
    <?php endif; ?>
</div>
<div class="card full-view">
  <div class="card-header">
    <h3 class="card-title"><?php echo $this->title ?></h3>
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
                    'columns' => [                    
                        'id:integer:Id',
                        [
                            'attribute' => 'form',
                            'format' => 'text',
                            'label' => t('Application form'),
                        //    'filter' => $searchModel->formTypesList(),
                            'value' => function (Request $model) {
                                return $model->form->title;
                            }
                        ],
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
                            'visibleButtons' => [
                                'delete' => function ($model) {
                                    /** @var Request $model */
                                    return ($model->status === Request::STATUS_DRAFT);                            
                                },
                                'update' => function ($model) {
                                    /** @var Request $model */
                                    return ($model->status === Request::STATUS_DRAFT);
                                }
                            ]                        
                        ],
                    ],
                ]); ?>
        </div>
    </div>


</div>

