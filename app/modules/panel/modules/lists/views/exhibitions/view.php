<?php

use app\core\helpers\View\Exhibition\ExhibitionStatusHelper;
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
                'title:text:' . Yii::t('app','Title'),
                'description:raw:' . Yii::t('app','Description'),
                'address:text:' . Yii::t('app','Location'),
                'company.name:text:' .  t('Organizer', 'exhibitions'),
                'start_date:date:' . Yii::t('app','Start date'),
                'end_date:date:' . Yii::t('app','End date'),
                'assembling_start:date:' . Yii::t('app','Start date of assembling'),
                'assembling_end:date:' . Yii::t('app','End date of assembling'),
                'disassembling_start:date:' . Yii::t('app','Start date of disassembling'),
                'disassembling_start:date:' . Yii::t('app','End date of disassembling'),
                [
                    'attribute' => 'status',
                    'label' => Yii::t('app', 'Status'),
                    'format' => 'raw',
                    'value' => ExhibitionStatusHelper::getStatusLabel($model->status)
                ],                
            ],
        ]); ?>
    </div>
</div>

