<?php
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\SearchModels\Geografy\EquipmentSearch;

/* @var $this yii\web\View */
/* @var $searchModel EquipmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Справочник доп. оборудования';
?>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo $this->title ?></h3>
        </div>
        <div class="bd-example">
           
                <p><?= Html::a('Новое оборудование', ['create'], ['class' => 'btn btn-success']) ?></p>
            
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
                        'code:text:Код',
                        'description:text:Описание',
                        'unit.name:text:Единица измерения',
                        'price:text:Цена',
                        ['class' => ActionColumn::class],
                    ],
                ]); ?>
        </div>
    </div>
</section>

