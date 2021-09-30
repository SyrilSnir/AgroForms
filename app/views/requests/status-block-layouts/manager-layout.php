<?php

use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\Forms\Requests\ChangeStatusForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $statusForm ChangeStatusForm */
?>    
<?php if (in_array($statusForm->status, [BaseRequest::STATUS_NEW])):?>
<div class="status-buttons-wrapper">
        
    <?php 
        
        $form = ActiveForm::begin([
            'id' => 'status-change-form'
        ]);
        if ($statusForm->status == BaseRequest::STATUS_NEW) {
            echo $form->field($statusForm, 'status')->hiddenInput(['value' => null])->label(false);
            echo Html::tag('div',Yii::t('app/requests', 'Transfer for payment'),['data-status' => BaseRequest::STATUS_INVOICED, 'class' => 'btn bg-gradient-success status-change-btn']);
        }
        ActiveForm::end();
    ?>    
</div>
<?php endif; ?>
