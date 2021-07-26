<?php

use app\models\SearchModels\Geography\RegionSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel RegionSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Управление регионами';
?>
<section class="content">
    <div class="card">
        <div class="bd-example">
           
                <p><?= Html::a('Новый регион', ['create'], ['class' => 'btn btn-success']) ?></p>
            
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
                        'name:text:Название региона',
                        'country.name:text:Страна',
                        ['class' => ActionColumn::class],
                    ],
                ]); ?>
        </div>
    </div>
</section>

