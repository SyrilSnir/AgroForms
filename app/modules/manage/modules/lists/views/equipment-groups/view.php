<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model EquipmentGroup */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
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
                    'name:text:Наимменование',
                    'description:text:Описание',
                    'name_eng:text:Наимменование (ENG)',
                    'description_eng:text:Описание (ENG)',                    
                ],
            ]); ?>
        </div>
    </div>


</div>

