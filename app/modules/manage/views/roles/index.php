<?php

use app\models\SearchModels\Users\UserTypeSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\View;

/* @var $this View */
/* @var $searchModel UserTypeSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Справочник пользовательских ролей';
?>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo $this->title ?></h3>
        </div>
        <div class="bd-example">          
            
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
                        'slug:text:Идентифтикатор',
                        [
                            'class' => ActionColumn::class,
                            'visibleButtons' => [
                                'delete' => false
                            ]                        
                        ],
                    ],
                ]); ?>
        </div>
    </div>
</section>

