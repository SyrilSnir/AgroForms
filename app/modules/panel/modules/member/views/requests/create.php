<?php


use app\core\manage\Auth\UserIdentity;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\widgets\Forms\DynamicFormWidget;
use app\widgets\Forms\StandWidget;

/** @var Form $form */
/** @var UserIdentity $user */

$this->title = Yii::t('app/title','Add request');
$widgetConfig = [
            'user' => $user,
            'formId' => $form->id
        ];

switch ($form->form_type_id) {
    case FormType::SPECIAL_STAND_FORM:
        echo StandWidget::widget($widgetConfig);
        break;
    case FormType::DYNAMIC_INFORMATION_FORM:
    case FormType::DYNAMIC_ORDER_FORM:
        echo DynamicFormWidget::widget($widgetConfig);
        break;
}
