<?php

use app\models\ActiveRecord\Exhibition\Exhibition;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Exhibition */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->title;
?>
<div class="category-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить категорию?',
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
                    'title:text:Название',
                    'title_eng:text:Название (ENG)',
                    'description:raw:Описание',
                    'description_eng:raw:Описание (ENG)',
                    'start_date:date:Дата начала',
                    'end_date:date:Дата окончания',
                ],
            ]); ?>
        </div>
    </div>


</div>

