<?php
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\SearchModels\Geografy\CountrySearch;

/* @var $this yii\web\View */
/* @var $searchModel CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление странами';
$adminList = Yii::$app->params['rootUsers'] ?? [];
?>
<section class="content">
    <div class="card">
<?php 

// Добавление нового пользователя из панели администратора не имеет смысла
/* ?>
    <p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php */ ?>
        <div class="card-header">
            <h3 class="card-title"><?php echo $this->title ?></h3>
        </div>
        <div class="bd-example">
           
                <p><?= Html::a('Новая страна', ['create'], ['class' => 'btn btn-success']) ?></p>
            
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
                        'name:text:Название страны',
                        'code:text:Идентификатор',
                        ['class' => ActionColumn::class],
                    ],
                ]); ?>
        </div>
    </div>
</section>

