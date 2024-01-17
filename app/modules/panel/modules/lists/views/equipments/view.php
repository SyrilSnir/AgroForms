<?php

use app\models\ActiveRecord\Nomenclature\Equipment;
use app\models\ActiveRecord\Nomenclature\EquipmentPrices;
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
        <?= Html::a(Yii::t('app','New'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app','Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete the equipment?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app','Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name:text:' . Yii::t('app','Name'),
                'equipmentGroup.name:text:' . Yii::t('app','Category'),
                'description:text:' . Yii::t('app','Description'),           
                'code:text:' . Yii::t('app','Code'),
                'unit.name:text:' . Yii::t('app','Unit'),
            ],
        ]); ?>
    </div>    
</div>
<?php
    $prices = $model->prices();
?>
<?php if (!empty($prices)): ?>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><?= t('Exhibition') ?></th>
                    <th><?= t('Price') ?></th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach ($prices as $item): ?>
                    <?php 
                        /** @var EquipmentPrices $item */                    
                    ?>
                <tr>
                    <td><?php echo ($item->exhibition->title) ?></td>
                    <td><?php echo($item->price) ?></td>
                </tr>
                    <?php endforeach; ?>
            </tbody>
            
        </table>        
    </div>
</div>
<?php endif; ?>

