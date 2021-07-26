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
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить форму?',
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
                'name:text:Тип формы',
                'description:raw:Описание',
                'name_eng:text:Тип формы (ENG)',
                'description_eng:raw:Описание (ENG)',                    
            ],
        ]); ?>
    </div>
</div>

