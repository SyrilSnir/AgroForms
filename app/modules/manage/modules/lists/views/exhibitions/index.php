<?php

use app\core\helpers\Utils\DateHelper;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\SearchModels\Exhibition\ExhibitionSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel ExhibitionSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Список выставок';
?>
<section class="content">
    <div class="card">
        <div class="bd-example">           
            <p><?= Html::a('Новая выставка', ['create'], ['class' => 'btn btn-success']) ?></p>            
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
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        if ($model['id'] == Yii::$app->params['activeExhibition']) {
                            return ['class' => 'active-exhibition'];
                        }
                    },                    
                    'filterModel' => $searchModel,
                    'columns' => [                    
                        'title:text:Название',
                        'title_eng:text:Название (ENG)',
                        'description:text:Описание',
                        'description_eng:text:Описание (ENG)',
                        [
                            'label' => 'Дата начала',
                            'attribute' => 'start_date',
                            'value' => function (Exhibition $model) {
                                /** @var Exhibition $model */
                                return DateHelper::timestampToDate($model->start_date);
                            }
                            
                        ],
                        [
                            'label' => 'Дата окончания',
                            'attribute' => 'end_date',
                            'value' => function (Exhibition $model) {
                                /** @var Exhibition $model */
                                return DateHelper::timestampToDate($model->end_date);
                            }
                            
                        ],                                
                        ['class' => ActionColumn::class],
                    ],
                ]); ?>
        </div>
    </div>
</section>

