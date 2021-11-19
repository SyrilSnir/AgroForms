<?php

use app\models\Forms\Manage\Exhibition\ExhibitionForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this */
/** @var ActiveForm $form */
/** @var ExhibitionForm $model */
?>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'titleEng')->textInput() ?>
    <?= $form->field($model, 'companyId')->widget(Select2::class,[
        'data' => $model->companiesList()
            ]) ?>   
    <?= $form->field($model, 'status')->dropDownList(\app\core\helpers\View\Exhibition\ExhibitionStatusHelper::statusList()) ?>                              
    <?= $form->field($model, 'address')->textInput() ?>                            
    <?= $form->field($model, 'description')->textInput() ?>
    <?= $form->field($model, 'descriptionEng')->textInput() ?>
    <?= $form->field($model, 'startDate')->widget(DatePicker::class, [
           'options' => ['placeholder' => ''],
            'value' => $model->startDate,
            'removeButton' => false,
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,        
           'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]); ?>
    <?= $form->field($model, 'endDate')->widget(DatePicker::class, [
           'options' => ['placeholder' => ''],
            'value' => $model->endDate,
            'removeButton' => false,
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
           'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]);?>
    <?= $form->field($model, 'startAssembling')->widget(DatePicker::class, [
           'options' => ['placeholder' => ''],
            'value' => $model->startAssembling,
            'removeButton' => false,
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
           'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]);?>
    <?= $form->field($model, 'endAssembling')->widget(DatePicker::class, [
           'options' => ['placeholder' => ''],
            'value' => $model->endAssembling,
            'removeButton' => false,
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
           'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]);?>
    <?= $form->field($model, 'startDisassembling')->widget(DatePicker::class, [
           'options' => ['placeholder' => ''],
            'value' => $model->startDisassembling,
            'removeButton' => false,
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
           'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]);?>
    <?= $form->field($model, 'endDisassembling')->widget(DatePicker::class, [
           'options' => ['placeholder' => ''],
            'value' => $model->endDisassembling,
            'removeButton' => false,
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
           'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]);?>                            
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
