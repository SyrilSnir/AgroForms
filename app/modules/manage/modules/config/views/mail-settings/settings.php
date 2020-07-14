<?php

use app\models\Forms\Manage\Configuration\SmtpConfigurationForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
/* @var $this View */
/** @var SmtpConfigurationForm $model  */
$this->title = 'Настройки отправки почты';
?>

<div class="mail-settings-form update-form">
<?php if (Yii::$app->session->has('configurationSaved')): ?>
    <div class="alert alert-primary" role="alert">
        <?php echo Yii::$app->session->getFlash('configurationSaved') ?>
    </div>
<?php endif; ?>    
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
                            
    <?= $form->field($model, 'smtpServer')->textInput() ?>      
    <?= $form->field($model, 'smtpPort')->textInput() ?> 

    <?= $form->field($model, 'tls')->widget(SwitchInput::class,[
        'pluginOptions' => [
                'onText' => 'Да',
                'offText' => 'Нет',
            ]
    ]) ?>                            
    <?= $form->field($model, 'userName')->textInput() ?>      
    <?= $form->field($model, 'password')->passwordInput() ?>  
                            <br>
    <?= $form->field($model, 'senderName')->textInput() ?>                         
    <?= $form->field($model, 'senderEmail')->textInput() ?>                         
                            
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>
    <?php ActiveForm::end(); ?>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
