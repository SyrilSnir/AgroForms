<?php

use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\SearchModels\Forms\FormSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel FormSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Справочник доступных форм';
?>
<section class="content">
    <div class="card">
        <div class="bd-example">
           
                <p><?= Html::a('Новая форма', ['create'], ['class' => 'btn btn-success']) ?></p>
            
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
                        'id:integer:Id',
                        'name:text:Название',
                        'title:text:Заголовок',
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
                ]); ?>
        </div>
    </div>
</section>

