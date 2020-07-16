<?php

use app\models\ActiveRecord\Forms\Stand;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Stand */
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
  <div class="card-header">
    <h3 class="card-title"><?php echo $this->title ?></h3>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name:text:Наимменование',
                    'description:html:Описание',
                    'price:text:Стоимость',
                ],
            ]); ?>
    <?php if ($model->image_url) :?>
        <div class="box">
            <div class="box-header with-border">Изображение стенда</div>
            <div class="box-body">
                    <?php echo Html::img($model->image_url, [
                        'class' => 'thumbnail',
                    ]) ?>
            </div>
        </div>
        <?php endif; ?>            
        </div>
    </div>


</div>

