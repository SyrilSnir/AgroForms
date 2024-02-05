<?php

use app\models\Forms\Manage\Contract\ContractMediaFeeForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var ActiveForm $form */
/** @var ContractMediaFeeForm $model */
?>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>      
    <?= $form->field($model, 'mediaFeeType')->dropDownList($model->mediaFeeTypesList()) ?>
    <?= $form->field($model, 'count')->textInput(['maxLength' => true]) ?>
    <?= $form->field($model, 'contractId')->hiddenInput()->label(false) ?>

    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Cancel'), [Url::previous()], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
