<?php

use app\models\Forms\Manage\Forms\SpecialPriceForm;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var ActiveForm $form */
/** @var SpecialPriceForm $model */
?>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>
    <?php 
        echo $form->field($model, 'startDate')->widget(DatePicker::class, [
           'options' => ['placeholder' => ''],
            'value' => $model->startDate,
            'removeButton' => false,
            'pickerIcon' => false,
            'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]);
        echo $form->field($model, 'endDate')->widget(DatePicker::class, [
           'options' => ['placeholder' => ''],
            'value' => $model->endDate,
            'removeButton' => false,
            'pickerIcon' => false,
            'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]);        
    ?>        
    <?= $form->field($model, 'price')->textInput(['maxLength' => true]) ?>
    <?= $form->field($model, 'fieldId')->hiddenInput()->label(false) ?>

    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Cancel'), [Url::previous()], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
