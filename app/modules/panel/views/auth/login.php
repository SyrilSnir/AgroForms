<?php

use app\models\Forms\User\Manage\LoginForm;
use lajax\languagepicker\widgets\LanguagePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model LoginForm */

$this->title = t('Control panel');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "<div class='input-group mb-3'>{input}<div class='input-group-append'>
            <div class='input-group-text'>
              <span class='fas fa-envelope'></span>
            </div>
          </div></div>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "<div class='input-group mb-3'>{input}
        <div class='input-group-append'>
            <div class='input-group-text'>
              <span class='fas fa-lock'></span>
            </div>
          </div></div>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b><?php echo t('Control panel') ?></b></a>
    </div>
    <?php if (Yii::$app->session->hasFlash('successActivate')): ?>
<div class="alert alert-primary" role="alert">
        <?php echo Yii::$app->session->getFlash('successActivate') ?>
</div>
<?php endif; ?>
    <!-- /.login-logo -->
    <div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?php echo t('Enter authorization data') ?></p>
        	
    <?php if( Yii::$app->session->hasFlash('error') ): ?>
    <div class="alert alert-error alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::$app->session->getFlash('error'); ?>
    </div>
<?php endif;?>
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'login', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('login')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row"> <?php /*
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>  */ ?>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton(t('Enter'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                <?= LanguagePicker::widget([
    'skin' => LanguagePicker::SKIN_BUTTON,
    'size' => LanguagePicker::SIZE_SMALL
]); ?>
            </div>
            <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>
<?php /*
        <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>
*/ ?>
    </div>
    <!-- /.login-box-body -->
    </div>
</div><!-- /.login-box -->



