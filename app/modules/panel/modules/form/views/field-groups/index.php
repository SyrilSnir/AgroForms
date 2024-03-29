<?php

use app\models\SearchModels\Forms\FieldGroupSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel FieldGroupSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title','Field groups');
?>
<section class="content full-view">
    <div class="card">
        <div class="bd-example">           
            <p><?= Html::a(Yii::t('app','New field group'), ['create'], ['class' => 'btn btn-success']) ?></p>            
        </div>
        <div class="card-body">

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
                        'name:text:' . Yii::t('app','Name'),
                        'description:raw:' . Yii::t('app','Description'),
                        'order:text:' . Yii::t('app','Serial number'),
                        ['class' => ActionColumn::class,
                             'visibleButtons' => [
                                'delete' => function ($model) {
                                    return ($model->id !== 0 );
                                } 
                            ]
                        ],
                    ],
                ]); ?>
        </div>
    </div>
</section>

