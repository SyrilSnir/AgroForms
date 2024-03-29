<?php

use app\models\Forms\FeedbackForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
/** @var View $this  */
/** @var FeedbackForm $model  */

$this->title = Yii::t('app/title','To write a message');
?>

<div class="create-form">
    
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message')->textarea();    
?>
    <?= $form->field($model, 'userId')->hiddenInput()->label(false);?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
