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
                    'pager' => require Yii::getAlias('@config') . DIRECTORY_SEPARATOR .'pager.php',
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

