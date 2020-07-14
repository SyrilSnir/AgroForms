<?php

use app\core\helpers\View\Request\RequestStatusHelper;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Requests\RequestStand;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Request */
/** @var RequestStand $requestForm */
$requestForm = $model->requestForm;
//dump($model->requestForm); die();
$this->title = 'Заявка №' . $model->id;
$attributes = [
    'formType.name:text:Тип формы',
    [
        'attribute' => 'status',
        'label' => 'Статус',
        'format' => 'raw',
        'value' => RequestStatusHelper::getStatusLabel($model->status)
    ],
    'user.fio:text:ФИО заказчика',
    'user.company.name:text:Компания'
    
];
$dopAttributes = [];
switch ($model->form_type_id) {
    case FormType::SPECIAL_STAND_FORM:
        $dopAttributes = [
            [
                'label' => 'Тип стенда',
                'value' => $requestForm->stand->name
            ],
            [
                'label' => 'Длинна, м.',
                'value' => $requestForm->length
            ],
            [
                'label' => 'Ширина, м.',
                'value' => $requestForm->width
            ], 
            [
                'label' => 'Площадь, м2',
                'value' => $requestForm->square
            ],
            [
                'label' => 'Фризовая надпись',
                'value' => $requestForm->frizeName
            ],         
            [
                'label' => 'Стоимость',
                'value' => $requestForm->amount . ' USD'
            ]
        ];
        break;
}

if (!empty($dopAttributes)) {
    $attributes = ArrayHelper::merge($attributes, $dopAttributes);
}
?>
<div class="view">
    <p>
        <?= Html::a('Экспорт в PDF', Url::to(['export', 'id' => $model->id]), ['class' => 'btn bg-gradient-danger']) ?>
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
