<?php

use app\models\Forms\Manage\Configuration\StandConfigurationForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
/* @var $this View */
/** @var StandConfigurationForm $model  */
$this->title = Yii::t('app','Stand settings');
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
    <?php $form = ActiveForm::begin(); ?>
                            
    <?= $form->field($model, 'frizeFreeDigits')->textInput() ?>      
    <?= $form->field($model, 'frizeDigitPrice')->textInput() ?>      
                            
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
