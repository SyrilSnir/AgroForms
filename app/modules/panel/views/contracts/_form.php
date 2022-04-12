<?php

use app\core\helpers\View\Contract\ContractStatusHelper;
use app\models\Forms\Manage\Contract\ContractForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this */
/** @var ActiveForm $form */
/** @var ContractForm $model */
?>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number')->textInput() ?>
    <?= $form->field($model, 'companyId')->widget(Select2::class,[
        'data' => $model->companiesList()
            ]) ?>   
    <?= $form->field($model, 'exhibitionId')->dropDownList($model->getExhibitionsList()) ?> 
    <?= $form->field($model, 'status')->dropDownList(ContractStatusHelper::statusList()) ?>                                                        

    <?= $form->field($model, 'date')->widget(DatePicker::class, [
           'options' => ['placeholder' => ''],
            'value' => $model->date,
            'removeButton' => false,
            'type' => DatePicker::TYPE_COMPONENT_PREPEND,        
           'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]); ?>
                           
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
