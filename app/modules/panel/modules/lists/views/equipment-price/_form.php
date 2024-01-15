<?php

use app\models\Forms\Nomenclature\EquipmentPricesForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this */
/** @var ActiveForm $form */
/** @var EquipmentPricesForm $model */
/** @var bool $isUpdate */
?>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'equipmentId')->hiddenInput()->label(false) ?>
    <?php if ($isUpdate): ?>
    <?= $form->field($model, 'exhibitionId')->hiddenInput()->label(false) ?>
    <?php else: ?>
    <?= $form->field($model, 'exhibitionId')->dropDownList($model->getExhibitionsList()) ?>
    <?php endif; ?>
    <?= $form->field($model, 'price')->textInput() ?>
                            
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Cancel'), yii\helpers\Url::previous(), ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
