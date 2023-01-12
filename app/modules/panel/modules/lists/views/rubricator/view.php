<?php

use app\models\ActiveRecord\Nomenclature\Rubricator;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var Rubricator $model */
$this->title = $model->name;
?>
<div class="category-view">
    <p>
        <?= Html::a(Yii::t('app','Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name:text:' . Yii::t('app','Name'),
                'parent.name:text:' . Yii::t('app','Parent section'),
            ],
        ]); ?>
    </div>
</div>
