<?php

use app\core\manage\Auth\UserIdentity;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\widgets\Forms\DynamicFormWidget;
use app\models\ActiveRecord\Requests\Request;
use app\widgets\Forms\StandWidget;

/** @var Request $request */
/** @var UserIdentity $user */

$this->title = Yii::t('app/title','Add request');
$widgetConfig = [
            'user' => $user,
        ];

switch ($request->type_id) {
    case FormType::SPECIAL_STAND_FORM:
        echo StandWidget::widget($widgetConfig);
        break;
    case FormType::DYNAMIC_INFORMATION_FORM:
    case FormType::DYNAMIC_ORDER_FORM:
        $widgetConfig['formId'] = $request->requestForm->form_id;
        echo DynamicFormWidget::widget($widgetConfig);
        break;
}

