<?php

use app\models\ActiveRecord\Forms\FieldGroup;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model FieldGroup */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->name;
?>
<div class="category-view">
    <p>
        <?= Html::a(Yii::t('app','Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($model->id !== FieldGroup::UNDEFINED_FIELD_GROUP): ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete the fields group?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app','Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name:text:' . Yii::t('app','Name'),                
                'description:text:' . Yii::t('app','Description'),               
                'order:text:' . Yii::t('app','Order')
            ],
        ]); ?>
    </div>
</div>

