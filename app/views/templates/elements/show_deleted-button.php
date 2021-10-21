<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

ob_start();
$form = ActiveForm::begin([
    'id' => 'show_deleted-form',
    'action' => '/' . $action,
    'method' => 'GET',
    'options' => [
        'class' => 'rows-counter',
        ]]);
echo Html::hiddenInput('id', $model->id);
echo $form->field($showDeletedForm, 'showDeleted')->checkbox(
    [
        'onchange'=> '$("#show_deleted-form").submit()',
        'uncheck' => null
    ]    
); 
ActiveForm::end();
return ob_get_clean();


