<?php

use app\models\SearchModels\Common\ValuteSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel ValuteSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Справочник валют';
?>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo $this->title ?></h3>
        </div>
        <div class="bd-example">
           
                <p><?= Html::a('Новая валюта', ['create'], ['class' => 'btn btn-success']) ?></p>
            
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
                        'name:text:Наименование',
                        'int_name:text:Международное название',
                        'char_code:text:Трехбуквенное обозначение',
                        'symbol:text:Символ',
                        ['class' => ActionColumn::class],
                    ],
                ]); ?>
        </div>
    </div>
</section>

