<?php

use app\models\SearchModels\Forms\ElementTypeSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel ElementTypeSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title','Directory of element types');
?>
<section class="content">
    <div class="card">
        <div class="bd-example">           
            <p><?= Html::a(Yii::t('app','New element type'), ['create'], ['class' => 'btn btn-success']) ?></p>            
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
                        'description:text:' . Yii::t('app','Description'),
                        ['class' => ActionColumn::class],
                    ],
                ]); ?>
        </div>
    </div>
</section>

