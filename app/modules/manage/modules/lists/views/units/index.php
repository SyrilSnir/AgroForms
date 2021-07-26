<?php
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\SearchModels\Nomenclature\UnitSearch;

/* @var $this yii\web\View */
/* @var $searchModel UnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Справочник единиц измерения';
?>
<section class="content">
    <div class="card">
        <div class="bd-example">
           
                <p><?= Html::a('Новая единица измерения', ['create'], ['class' => 'btn btn-success']) ?></p>
            
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
                        'short_name:text:Краткое наименование',
                        ['class' => ActionColumn::class],
                    ],
                ]); ?>
        </div>
    </div>
</section>

