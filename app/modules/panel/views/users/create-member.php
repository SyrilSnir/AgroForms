<?php

use app\models\Forms\Manage\Users\MemberForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this  */
/** @var MemberForm $model  */
/** @var bool $update */
$this->title = Yii::t('app/title', 'New member')
?>

<div class="create-form">
    

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->textInput() ?>
    <?= $form->field($model, 'fio')->textInput() ?>
    <?= $form->field($model, 'phone')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>

    <?php if ($update): ?>                        
        <?= $form->field($model, 'userType')->dropDownList($model->typeList()) ?>             
    <?php endif; ?>    
                            
    <?= $form->field($model, 'position')->textInput() ?>                              
    <?= $form->field($model, 'gender')->dropDownList($model->getGenderData()) ?>                                                                              
    <?php 
        echo $form->field($model, 'birthday')->widget(DatePicker::class, [
           'options' => ['placeholder' => t('Date of birthday','user')],
            'value' => $model->birthday,
            'removeButton' => false,
            'pickerIcon' => false,
            'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]);    
    ?>
                            
    <?= $form->field($model, 'language')->dropDownList($model->languagesList()) ?>
                            <br>
    <?= $form->field($model, 'company')->widget(Select2::class,[
        'data' => $model->organizationList()
            ]) ?>                                
    <div class="form-group">
        <?= Html::submitButton(t('Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(t('Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

