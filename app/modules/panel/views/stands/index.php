<?php

use app\models\ActiveRecord\Forms\Stand;
use app\models\SearchModels\Forms\StandSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel StandSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title', 'Available stands');
?>
<section class="content">
    <div class="card">
        <div class="bd-example">           
            <p><?= Html::a(Yii::t('app', 'New stand'), ['create'], ['class' => 'btn btn-success']) ?></p>            
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
                        'name:text:' . Yii::t('app', 'Name'),
                        'description:html:' . Yii::t('app', 'Description'),
                        'exhibition.title:text:' . Yii::t('app', 'Exhibition'),
                        [
                            'label' => Yii::t('app', 'Stand image'),
                            'value' => function (Stand $model) {
                                return Html::img($model->image_url,['style' => 'width: 80px']);
                            },
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 100px'],
                        ],                        
                        ['class' => ActionColumn::class],
                    ],
                ]); ?>
        </div>
    </div>
</section>

