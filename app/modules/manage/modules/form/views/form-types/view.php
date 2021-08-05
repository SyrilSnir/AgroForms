<?php

use app\models\ActiveRecord\Forms\FormType;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model FormType */
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
                'name:text:' . Yii::t('app/requests', 'Form type'),
                'description:raw:' . Yii::t('app', 'Description'),
                'name_eng:text:' . Yii::t('app/requests', 'Form type') .' (ENG)',
                'description_eng:raw:' . Yii::t('app', 'Description') . ' (ENG)',                    
            ],
        ]); ?>
    </div>
</div>

