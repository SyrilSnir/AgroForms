<?php

use app\core\helpers\View\Request\RequestStatusHelper;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Requests\RequestDynamicForm;
use app\models\ActiveRecord\Requests\RequestStand;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Request */
//dump($model->requestForm); die();
$this->title = 'Заявка №' . $model->id;
$attributes = [
    'formType.name:text:Тип формы',
    [
        'attribute' => 'status',
        'label' => 'Статус',
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
        <?= Html::a('Вернуться', ['index'], ['class' => 'btn btn-secondary']) ?>
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
