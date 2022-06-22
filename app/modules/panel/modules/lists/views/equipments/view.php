<?php

use app\models\ActiveRecord\Nomenclature\Equipment;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Equipment */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->name;
?>
<div class="category-view">
    <p>
        <?= Html::a(Yii::t('app','New'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app','Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete the equipment?'),
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
                'name:text:' . Yii::t('app','Name'),
                'equipmentGroup.name:text:' . Yii::t('app','Category'),
                'description:text:' . Yii::t('app','Description'),           
                'code:text:' . Yii::t('app','Code'),
                'unit.name:text:' . Yii::t('app','Unit'),
                'price:text:' . Yii::t('app','Price'),
            ],
        ]); ?>
    </div>
</div>

