<?php

use app\models\Forms\Manage\Users\UserForm;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this */
/** @var ActiveForm $form */
/** @var UserForm $model */
?>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $this->title ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->textInput() ?>
    <?= $form->field($model, 'fio')->textInput() ?>
    <?= $form->field($model, 'phone')->textInput() ?>
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
