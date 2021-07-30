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
        <div class="bd-example">           
            <p><?= Html::a('Новая страна', ['create'], ['class' => 'btn btn-success']) ?></p>            
        </div>
        <div class="card-body">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pager' => require Yii::getAlias('@config') . DIRECTORY_SEPARATOR .'pager.php',
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

