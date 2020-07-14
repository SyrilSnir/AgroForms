<?php

use app\models\Forms\Manage\StandConfigurationForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
/* @var $this View */
/** @var StandConfigurationForm $model  */
$this->title = 'Настройки стендов';
?>

<div class="stand-settings-form update-form">
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
                            
    <?= $form->field($model, 'frizeFreeDigits')->textInput() ?>      
    <?= $form->field($model, 'frizeDigitPrice')->textInput() ?>      
                            
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
