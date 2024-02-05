<?php

use app\core\helpers\View\Contract\ContractStatusHelper;
use app\core\helpers\View\YesNoStatusHelper;
use app\models\ActiveRecord\Contract\Contracts;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Contracts */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = t('Contract', 'contracts') . ' № ' .$model->number;
$attributes = [
    'number:text:' . Yii::t('app','Number of contract'),
    'company.name:text:' . t('Company','user'),
    'exhibition.title:text:' . t('Exhibition'),
    'hall.name:text:' . t('Hall'),
    'standNumber.number:text:' . t('Stand`s number'),
    'stand_square:text:' . t('Stand`s square, m2'),
    'registration_fee:text:' . t('Registration fee (number of pieces)'),    
];
if ($model->mediaFees) {
    $attributes[] = [
        'attribute' => 'mediaFees',
        'label' => t('Media contributions'),
        'format' => 'raw',
        'value' => $this->renderFile(Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'media-fees.php',[
            'mediaFees' => $model->mediaFees
        ]),
    ];
}
$attributes = ArrayHelper::merge($attributes, [
                'date:date:' . Yii::t('app','Date'),
                [
                    'attribute' => 'status',
                    'label' => Yii::t('app', 'Status'),
                    'format' => 'raw',
                    'value' => ContractStatusHelper::getStatusLabel($model->status)
                ],
                [
                    'attribute' => 'is_logo',
                    'label' => t('Logo available'),
                    'format' => 'raw',
                    'value' => YesNoStatusHelper::getStatusLabel($model->is_logo)
                ] 
        ]);
?>
<div class="category-view col-8">
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
<section class="content">    
    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $attributes,
            ]); ?>
        </div>
    </div>
</section>
</div>

