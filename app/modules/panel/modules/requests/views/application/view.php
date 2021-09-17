<?php

use app\core\helpers\View\Request\RequestStatusHelper;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Requests\RequestStand;
use app\models\ActiveRecord\Users\UserType;
use app\models\Forms\Requests\ChangeStatusForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $statusForm ChangeStatusForm  */
/* @var $this View */
/* @var $model Request */
/* @var $requestForm RequestStand */
$requestForm = $model->requestForm;
$this->title = Yii::t('app/requests', 'Application №') . $model->id;
$attributes = [
    'formType.name:text:' . Yii::t('app/requests', 'Form type'),
    [
        'attribute' => 'status',
        'label' => Yii::t('app', 'Status'),
        'format' => 'raw',
        'value' => RequestStatusHelper::getStatusLabel($model->status)
    ],
    'user.fio:text:' . Yii::t('app/requests','Full name of the customer'),
    'user.company.name:text:' . Yii::t('app/company','Company')
    
];
/*
$dopAttributes = [];
switch ($model->form->form_type_id) {
    case FormType::SPECIAL_STAND_FORM:
        $dopAttributes = [
            [
                'label' => Yii::t('app/requests', 'Stand type'),
                'value' => $requestForm->stand->name
            ],
            [
                'label' => Yii::t('app/requests', 'Length, m.'),
                'value' => $requestForm->length
            ],
            [
                'label' => Yii::t('app/requests', 'Width, m.'),
                'value' => $requestForm->width
            ], 
            [
                'label' => Yii::t('app/requests', 'Space, m<sup>2</sup>'),
                'value' => $requestForm->square
            ],
            [
                'label' => Yii::t('app/requests', 'Fascia name'),
                'value' => $requestForm->frizeName
            ],         
            [
                'label' =>  Yii::t('app/requests', 'Price'),
                'value' => $requestForm->amount . ' USD'
            ]
        ];
        break;
}
*/
if (!empty($dopAttributes)) {
    $attributes = ArrayHelper::merge($attributes, $dopAttributes);
}
?>

<div class="view">
    <?php if (Yii::$app->session->hasFlash('success')):?>
    <div class="alert alert-primary" role="alert">
            <?php echo Yii::$app->session->getFlash('success')?>
    </div>
    <?php endif ;?>

    <?php 
        $form = ActiveForm::begin();
        echo $form->field($statusForm, 'status')->dropDownList(RequestStatusHelper::statusList(Yii::$app->user->can(UserType::MEMBER_USER_TYPE)));
        echo Html::submitButton(Yii::t('app/requests', 'Change status'),['class' => 'btn bg-gradient-success']);
        ActiveForm::end();
    ?>
    <p>
        <br><br>
        <?= Html::a(Yii::t('app/requests', 'Export to PDF'), Url::to(['export', 'id' => $model->id]), ['class' => 'btn bg-gradient-danger']) ?>
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>    
    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => $attributes,
            ]); ?>
        </div>
    </div>
</div>
