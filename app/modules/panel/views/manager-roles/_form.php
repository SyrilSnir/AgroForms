<?php

use app\models\ActiveRecord\Users\ManagerRoles;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var ActiveForm $form */
/** @var ManagerRoles $model */
?>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxLength' => true]) ?>
    <?= $form->field($model, 'nameEng')->textInput(['maxLength' => true]) ?>

    <div class="card card-default">
        <div class="card-header">
            <h3><?= t('User management')?></h3>
        </div>
        <div class="card-body">
    <?= $form->field($model, 'u_view')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => Yii::t('app', 'Yes'),
                        'offText' => Yii::t('app', 'No'),
                    ],
                'pluginEvents' => [
                    "init.bootstrapSwitch" => "function(e) { console.log('aaaa'); }",
                    "switchChange.bootstrapSwitch" => 
                    "function(e) { e.target.checked ? $('#u-rules-container').fadeIn() :
                        $('#u-rules-container').fadeOut(); }",
            ]
            ]);  ?>
    <div id="u-rules-container" <?php if (!$model->u_view): ?>style="display: none"<?php endif; ?>>
    <?= $form->field($model, 'u_create')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>                                
    <?= $form->field($model, 'u_edit')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>                                
    <?= $form->field($model, 'u_delete')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>         
        </div>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h3><?= t('Company management')?></h3>
        </div>
        <div class="card-body">
    <?= $form->field($model, 'c_view')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => Yii::t('app', 'Yes'),
                        'offText' => Yii::t('app', 'No'),
                    ],
                'pluginEvents' => [
                    "init.bootstrapSwitch" => "function(e) { console.log('aaaa'); }",
                    "switchChange.bootstrapSwitch" => 
                    "function(e) { e.target.checked ? $('#c-rules-container').fadeIn() :
                        $('#c-rules-container').fadeOut(); }",
            ]
            ]);  ?>
    <div id="c-rules-container" <?php if (!$model->c_view): ?>style="display: none"<?php endif; ?>>
    <?= $form->field($model, 'c_create')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>                                
    <?= $form->field($model, 'c_edit')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>                                
    <?= $form->field($model, 'c_delete')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>         
        </div>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h3><?= t('Document management')?></h3>
        </div>
        <div class="card-body">
    <?= $form->field($model, 'd_view')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => Yii::t('app', 'Yes'),
                        'offText' => Yii::t('app', 'No'),
                    ],
                'pluginEvents' => [
                    "init.bootstrapSwitch" => "function(e) { console.log('aaaa'); }",
                    "switchChange.bootstrapSwitch" => 
                    "function(e) { e.target.checked ? $('#d-rules-container').fadeIn() :
                        $('#d-rules-container').fadeOut(); }",
            ]
            ]);  ?>
    <div id="d-rules-container" <?php if (!$model->d_view): ?>style="display: none"<?php endif; ?>>
    <?= $form->field($model, 'd_create')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>                                
    <?= $form->field($model, 'd_edit')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>                                
    <?= $form->field($model, 'd_delete')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>         
        </div>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h3><?= t('Contract management')?></h3>
        </div>
        <div class="card-body">
    <?= $form->field($model, 'co_view')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => Yii::t('app', 'Yes'),
                        'offText' => Yii::t('app', 'No'),
                    ],
                'pluginEvents' => [
                    "init.bootstrapSwitch" => "function(e) { console.log('aaaa'); }",
                    "switchChange.bootstrapSwitch" => 
                    "function(e) { e.target.checked ? $('#co-rules-container').fadeIn() :
                        $('#co-ules-container').fadeOut(); }",
            ]
            ]);  ?>
    <div id="co-rules-container" <?php if (!$model->co_view): ?>style="display: none"<?php endif; ?>>
    <?= $form->field($model, 'co_create')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>                                
    <?= $form->field($model, 'co_edit')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>                                
    <?= $form->field($model, 'co_delete')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => 'Да',
                            'offText' => 'Нет',
                        ]
        ]); 
        ?>         
        </div>
        </div>
    </div>
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
