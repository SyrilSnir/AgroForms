<?php

use app\core\helpers\View\Contract\ContractStatusHelper;
use app\models\ActiveRecord\Contract\Contracts;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Contracts */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = t('Contract', 'contracts') . ' № ' .$model->number;
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
                'number:text:' . Yii::t('app','Number of contract'),
                'company.name:text:' . t('Company','user'),
                'date:date:' . Yii::t('app','Date'),
                [
                    'attribute' => 'status',
                    'label' => Yii::t('app', 'Status'),
                    'format' => 'raw',
                    'value' => ContractStatusHelper::getStatusLabel($model->status)
                ],                
            ],
        ]); ?>
    </div>
</div>

