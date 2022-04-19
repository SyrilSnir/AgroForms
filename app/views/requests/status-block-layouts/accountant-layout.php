<?php

use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\Forms\Requests\EditRequestForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $statusForm EditRequestForm */
?>    
<?php if (in_array($statusForm->status, [BaseRequest::STATUS_ACCEPTED, BaseRequest::STATUS_INVOICED,BaseRequest::STATUS_PARTIAL_PAID])):?>
<div class="status-buttons-wrapper">
        
    <?php 
        
        $form = ActiveForm::begin([
            'id' => 'status-change-form'
        ]);
        echo $form->field($statusForm, 'status')->hiddenInput(['value' => null])->label(false);                
        if ($statusForm->status == BaseRequest::STATUS_ACCEPTED) {
            $form->action = \yii\helpers\Url::to(['invoice','id' => $statusForm->requestId]);
            echo Html::tag('div',Yii::t('app/requests', 'Invoice'),['data-status' => BaseRequest::STATUS_INVOICED, 'class' => 'btn bg-gradient-success status-change-btn']);
        } else {
            echo Html::tag('div',Yii::t('app/requests', 'Application paid'),['data-status' => BaseRequest::STATUS_PAID, 'class' => 'btn bg-gradient-success status-change-btn']);            
        }
        if ($statusForm->status == BaseRequest::STATUS_INVOICED) {
            echo Html::tag('div',Yii::t('app/requests', 'Partial payment'),['data-status' => BaseRequest::STATUS_PARTIAL_PAID, 'class' => 'btn bg-gradient-success status-change-btn']);
        }        
        ActiveForm::end();
    ?>    
</div>
<?php endif; ?>
