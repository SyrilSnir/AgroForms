<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ActiveRecord\Geografy\City;

/* @var $this yii\web\View */
/* @var $model City */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
?>
<div class="city-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите город?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Вернуться', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo $this->title ?></h3>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name:text:Название города',
                    'country.name:text:Страна',
                    'region.name:text:Регион',
                ],
            ]); ?>
        </div>
    </div>
</div>

