<?php

use app\core\helpers\View\Request\RequestStatusHelper;
use app\models\ActiveRecord\Requests\Request;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Request */
//dump($model->requestForm); die();
$this->title = t('Application №','requests') . $model->id;
$attributes = [
    'formType.name:text:' . t('Form type', 'requests'),
    [
        'attribute' => 'status',
        'label' => t('Status'),
        'format' => 'raw',
        'value' => RequestStatusHelper::getStatusLabel($model->status)
    ]    
    
];

if (!empty($dopAttributes)) {
    $attributes = ArrayHelper::merge($attributes, $dopAttributes);
}
?>
<div class="view">
    <p>
        <?= Html::a(t('Back'), Url::previous(), ['class' => 'btn btn-secondary']) ?>
    </p>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo $this->title ?></h3>        
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $attributes,
            ]); ?>
        </div>
    </div>
</div>
