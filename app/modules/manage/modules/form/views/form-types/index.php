<?php

use app\models\SearchModels\Forms\FormTypeSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel FormTypeSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app','Form types');
?>
<section class="content">
    <div class="card">
    <div class="card-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [                    
                        'name:text:' . Yii::t('app','Name'),
                        'description:raw:' . Yii::t('app','Description'),
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

