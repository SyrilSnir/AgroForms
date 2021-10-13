<?php

use SebastianBergmann\CodeCoverage\Report\Xml\Unit;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Unit */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = 'Специальная цена';
?>
<div class="category-view">
    <p>
        <?= Html::a(Yii::t('app','Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Back'), [Url::previous() ], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'start_date:date:' . Yii::t('app','Start date'),
                'end_date:date:' . Yii::t('app','End date'),
                'price:text:' . Yii::t('app','Price'),
            ],
        ]); ?>
    </div>
</div>

