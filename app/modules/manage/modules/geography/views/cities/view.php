<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ActiveRecord\Geografy\City;

/* @var $this yii\web\View */
/* @var $model City */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
?>
<div class="city-view">
    <p>
        <?= Html::a(Yii::t('app','Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete the city?'),
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
                    'name:text:' . Yii::t('app','City'),
                    'country.name:text:' . Yii::t('app','Country'),
                    'region.name:text:' . Yii::t('app','Region'),
                ],
            ]); ?>
        </div>
    </div>
</div>

