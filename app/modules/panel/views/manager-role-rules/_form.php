<?php

use app\models\Forms\Manage\Users\ManagerRoleRulesForm;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var ActiveForm $form */
/** @var ManagerRoleRulesForm $model */
?>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'roleId')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'formId')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'roleName')->textInput(['disabled' => true]) ?>
    <?= $form->field($model, 'formName')->textInput(['disabled' => true]) ?>
    <?= $form->field($model, 'view')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => Yii::t('app', 'Yes'),
                        'offText' => Yii::t('app', 'No'),
                    ],
                'pluginEvents' => [
                    "init.bootstrapSwitch" => "function(e) { console.log('aaaa'); }",
                    "switchChange.bootstrapSwitch" => 
                    "function(e) { e.target.checked ? $('#rules-container').fadeIn() :
                        $('#rules-container').fadeOut(); }",
            ]
            ]);  ?>
<div id="rules-container" <?php if (!$model->view): ?>style="display: none"<?php endif; ?>>
<?= $form->field($model, 'accept')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => 'Да',
                        'offText' => 'Нет',
                    ]
    ]); 
    ?>                                
<?= $form->field($model, 'publicate')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => 'Да',
                        'offText' => 'Нет',
                    ]
    ]); 
    ?>                                
<?= $form->field($model, 'pay')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => 'Да',
                        'offText' => 'Нет',
                    ]
    ]); 
    ?>                                
<?= $form->field($model, 'delete')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => 'Да',
                        'offText' => 'Нет',
                    ]
    ]); 
    ?>                                
    </div>
                            
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), [Url::previous()], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>