<?php

use app\models\ActiveRecord\Forms\Field;
use app\models\SearchModels\Forms\FieldSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel FieldSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Справочник полей';
?>
<section class="content">
    <div class="card">
        <div class="bd-example">           
            <p><?= Html::a('Новое поле', ['create'], ['class' => 'btn btn-success']) ?></p>            
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
                        'order:integer:Порядковый номер',
                        [
                            'filter' => $searchModel->formsList(),
                            'attribute' => 'formId',
                            'label' => 'Форма',
                            'value' => function (Field $model) {
                                return $model->form->name;
                            }                         
                        ],
                        'name:text:Название',
                        [
                            'attribute' => 'fieldGroupId',
                            'label' => 'Группа',
                            'filter' => $searchModel->fieldGroupList(),
                            'value' => function (Field $model) {
                                return $model->fieldGroup ? $model->fieldGroup->name: 'Не задана';
                            }
                        ],
                        ['class' => ActionColumn::class],
                    ],
                ]); ?>
        </div>
    </div>
</section>

