<?php

use app\models\ActiveRecord\Exhibition\Exhibition;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Exhibition */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->title;
?>
<div class="category-view">
    <p>
        <?= Html::a(Yii::t('app','Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete the exhibition?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app','Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'title:text:' . Yii::t('app','Title'),
                'title_eng:text:' . Yii::t('app','Title') .' (ENG)',
                'description:raw:' . Yii::t('app','Description'),
                'description_eng:raw:' . Yii::t('app','Description') .' (ENG)',
                'start_date:date:' . Yii::t('app','Start date'),
                'end_date:date:' . Yii::t('app','End date'),
            ],
        ]); ?>
    </div>
</div>

