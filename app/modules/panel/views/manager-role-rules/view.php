<?php

use app\core\helpers\View\YesNoStatusHelper;
use app\models\ActiveRecord\Users\ManagerRoleRules;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model ManagerRoleRules */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->form->name;
?>
<div class="view">
    <p>
        <?= Html::a(Yii::t('app', 'Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete the rule?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Back'), [Url::previous()], ['class' => 'btn btn-secondary']) ?>
    </p>
    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'exhibition',
                        'label' => Yii::t('app', 'Exhibition'),
                        'value' => $model->form->exhibition->title,
                    ],
                    [
                        'attribute' => 'form',
                        'label' => Yii::t('app', 'Form'),
                        'value' => $model->form->title . ':' . $model->form->name,
                    ],
                    [
                        'attribute' => 'view',
                        'label' => Yii::t('app', 'View applications'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->r_view),
                    ],
                    [
                        'attribute' => 'accept',
                        'label' => Yii::t('app', 'Accept/reject application'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->r_accept),
                    ],
                    [
                        'attribute' => 'publicate',
                        'label' => Yii::t('app', 'Post an application'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->r_publicate),
                    ],
                    [
                        'attribute' => 'delete',
                        'label' => Yii::t('app', 'Deleting applications'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->r_delete),
                    ],
                    [
                        'attribute' => 'pay',
                        'label' => Yii::t('app', 'Changing payment status'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->r_pay),
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

