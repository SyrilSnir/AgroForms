<?php

use app\core\helpers\View\Request\RequestStatusHelper;
use app\models\Forms\Requests\EditRequestForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var ActiveForm $form */
/** @var EditRequestForm $model */
$this->title = Yii::t('app/requests', 'Change status');
?>

<div class="update-form">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'status')->dropDownList(RequestStatusHelper::statusList(false)) ?>
    <?= $form->field($model, 'contractId')->widget(Select2::class,[
        'data' => $model->contractsList(),
        'options' => ['placeholder' => t('Select contract number...', 'contracts')],
        'pluginOptions' => [
          'allowClear' => true
        ],
            ]); ?> 

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>