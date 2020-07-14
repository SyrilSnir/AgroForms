<?php

use app\models\ActiveRecord\Users\User;
use app\models\Forms\User\Manage\SetNewPasswordForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
/** @var SetNewPasswordForm $model */

/** @var User $user */

switch ($user->genre) {
    case 1:
        $appeal = 'Уважаемый';
        break;
    case 2:
        $appeal = 'Уважаемая';
        break;
    default :
        $appeal = 'Уважаемый(ая)';        
        break;
        
}
?>


<div class="container">
    <h3>
        <?php echo "{$appeal} {$user->fio}" ?> добро пожаловать закрытую часть портала,
        посвещенного выставке АГРОСАЛОН.
    </h3>
    <h4>
        Для активации учетной записи необходимо задать пароль.
    </h4>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                    'id' => 'activate-user-form',
                    'action' => '/activate/success'
                ]); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>
                <?= $form->field($model, 'token')->hiddenInput()->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>    

