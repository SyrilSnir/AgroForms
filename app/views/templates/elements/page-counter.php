<?php

use yii\bootstrap4\ActiveForm;

ob_start();
$form = ActiveForm::begin([
    'id' => 'page-form',
    'action' => '/' . $action,
    'method' => 'GET',
    'options' => [
        'class' => 'rows-counter',
        ]]);
echo $form->field($rowsCountForm, 'rowsCount')->dropdownList(
        [
            '' => Yii::t('app', 'All'),
            10 => 10,
            20=> 20,
            50 => 50,
        ],
        [
            'onchange'=>'this.form.submit()'
        ]
        );    
ActiveForm::end();
return ob_get_clean();
