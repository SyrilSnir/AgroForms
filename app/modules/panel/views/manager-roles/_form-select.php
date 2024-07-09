<?php

use app\core\helpers\Lists\ExhibitionHelper;
use app\core\helpers\Lists\FormsHelper;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;

$exHelper = new ExhibitionHelper();
$formsHelper = new FormsHelper();
echo Select2::widget([
    'options'=>[
        'id'=> 'ex-id'
    ],
    'name' => 'exhibition',
    'data' => $exHelper->getExhibitionsList(true),

]);
echo DepDrop::widget([
    'name' => 'form',
    'data' => $formsHelper->formsList(true),
    'options' => [
        'id'=>'frm-id',
    ],
    'pluginOptions' => [
        'placeholder' => 'Все формы',
        'url' => '/api/exhibition/get-forms/?showDeleted=false',
        'depends' => [
            'ex-id'
        ]            
    ]
]);
