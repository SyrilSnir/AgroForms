<?php

use app\core\helpers\View\Request\RequestStatusHelper;
use app\models\ActiveRecord\Users\UserType;
use app\models\Forms\Requests\EditRequestForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $statusForm EditRequestForm */
?>    
<div class="change-status-block">
        
    <?php 
        $form = ActiveForm::begin();
        echo $form->field($statusForm, 'status')->dropDownList(RequestStatusHelper::statusList(Yii::$app->user->can(UserType::MEMBER_USER_TYPE)));
        echo Html::submitButton(Yii::t('app/requests', 'Change status'),['class' => 'btn bg-gradient-success']);
        ActiveForm::end();
    ?>    
</div>
