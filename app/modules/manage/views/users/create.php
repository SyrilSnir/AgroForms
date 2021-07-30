<?php

use app\models\Forms\Manage\Users\CreateForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this  */
/** @var CreateForm $model  */

$this->title = Yii::t('app/user','Create new user');
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
    <?= $form->field($model, 'userType')->dropDownList($model->typeList()) ?>
    <?= $form->field($model, 'company')->widget(Select2::class,[
        'data' => $model->organizationList()
            ]) ?>                          
    <?php 
        echo $form->field($model, 'birthday')->widget(DatePicker::class, [
           'options' => ['placeholder' => Yii::t('app/user','Date of birthday')],
            'value' => $model->birthday,
            'removeButton' => false,
            'pickerIcon' => false,
           'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]);    
    ?>
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

</div>

