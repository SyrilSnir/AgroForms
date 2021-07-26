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

$this->title = Yii::t('app/title', 'Requests list');
?>

<div class="card full-view">
  <div class="card-header">
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
                        'user.company.name:text:Заказчик',
                        [
                            'attribute' => 'formType',
                            'format' => 'text',
                            'label' => 'Тип формы',
                            'filter' => $searchModel->formTypesList(),
                            'value' => 'formType.name',
                        ],
                        [
                            'attribute' => 'status',
                            'label' => 'Статус',
                            'format' => 'raw',
                            'filter' => RequestStatusHelper::statusList(false),
                            'value' => function (Request $model) {
                                return RequestStatusHelper::getStatusLabel($model->status);
                            }
                        ],
                        'created_at:datetime:Дата создания',
                        
                        [
                            'class' => ActionColumn::class,
                            'visibleButtons' => [
                            //    'delete' => false,
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

