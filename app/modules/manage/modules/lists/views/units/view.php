<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Unit */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
?>
<div class="category-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить единицу измерения?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Вернуться', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name:text:Наимменование',
                'short_name:text:Краткое наимменование',
                'name_eng:text:Наимменование (ENG)',
                'short_name_eng:text:Краткое наимменование (ENG)',
            ],
        ]); ?>
    </div>
</div>

