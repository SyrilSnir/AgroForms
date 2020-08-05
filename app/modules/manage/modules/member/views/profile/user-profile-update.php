<?php

use kartik\date\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
use app\models\Forms\Manage\Users\MemberForm;


/** @var View $this */
/** @var ActiveForm $form */
/** @var MemberForm $model */

$this->title = Yii::t('app/user','User edit');
?>

<div class="update-form">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $this->title ?></h3>                    
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
             <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'login')->textInput(['disabled' => '']) ?>   
                <?= $form->field($model, 'fio')->textInput(['disabled' => '']) ?>                            
                <?= $form->field($model, 'email')->textInput(['disabled' => '']) ?>   
                <?= $form->field($model, 'phone')->textInput() ?>  
                <?= $form->field($model, 'position')->textInput() ?>  
                <?= $form->field($model, 'gender')->dropDownList([
                    0 => 'Не задано',
                    1 => 'Мужской',
                    2 => 'Женский'
                ]) ?>                             
            <?php 
                echo $form->field($model, 'birthday')->widget(DatePicker::class, [
                   'options' => ['placeholder' => 'Дата рождения'],
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

