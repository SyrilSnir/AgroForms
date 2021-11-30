<?php

use app\models\ActiveRecord\Users\UserType;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model UserType */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->name;
?>
<div class="category-view">
    <p>
        <?= Html::a(Yii::t('app', 'Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name:text:'. Yii::t('app', 'Role'),
                'slug:text:' . Yii::t('app', 'Identifier'),
            ],
        ]); ?>
    </div>
</div>
    </div>

