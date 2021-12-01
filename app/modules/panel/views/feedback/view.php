<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ActiveRecord\FeedbackFormModel;

/* @var $this yii\web\View */
/* @var $model FeedbackFormModel */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = t('Message') .' № ' . $model->user->id;
?>
<div class="city-view">
    <p>
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
                    'created_at:datetime:' . Yii::t('app','Date and time'),
                    'user.fio:text:' . Yii::t('app/user','Full name'),
                    'message:text:' . Yii::t('app','Message'),
                ],
            ]); ?>
        </div>
    </div>
</div>

