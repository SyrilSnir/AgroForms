<?php

use app\models\ActiveRecord\Nomenclature\Equipment;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Equipment */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->name;
?>
<div class="category-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить оборудование?',
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
                    'name_eng:text:Наимменование (ENG)',
                    'equipmentGroup.name:text:Категория',
                    'description:text:Описание',
                    'description_eng:text:Описание (ENG)',
                    'code:text:Код',
                    'unit.name:text:Единица измерения',
                    'price:text:Цена',
                ],
            ]); ?>
        </div>
    </div>


</div>

