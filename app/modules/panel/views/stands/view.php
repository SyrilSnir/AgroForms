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
        <?= Html::a(Yii::t('app','Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete the stand?'),
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
                    'id',
                    'name:text:' . Yii::t('app','Name'),
                    'description:html:' . Yii::t('app','Description'),
                    'price:text:' . Yii::t('app','Price'),
                ],
            ]); ?>
    <?php if ($model->image_url) :?>
        <div class="box">
          <div class="box-header with-border"><?php echo Yii::t('app','Stand image')?></div>
            <div class="box-body">
                    <?php echo Html::img($model->image_url, [
                        'class' => 'thumbnail',
                    ]) ?>
            </div>
        </div>
        <?php endif; ?>            
    </div>


</div>

