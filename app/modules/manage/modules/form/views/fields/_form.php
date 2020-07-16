<?php

use app\models\ActiveRecord\Forms\ElementType;
use app\models\Forms\Manage\Forms\FieldForm;
use kartik\switchinput\SwitchInput;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use function GuzzleHttp\json_encode;



/** @var View $this */
/** @var ActiveForm $form */
/** @var FieldForm $model */
/** @var int|null $formId */

if ($formId) {
    $model->formId = $formId;
}
?>

    <section 
        id="fields-config" 
        class="content"
        data-text="<?php echo json_encode(ElementType::TEXT_BLOCKS)?>"
        data-html="<?php echo json_encode(ElementType::HTML_BLOCKS)?>"
        data-required="<?php echo json_encode(ElementType::HAS_REQUIRED)?>"
        data-number="<?php echo json_encode(ElementType::NUMBER_PARAMS)?>"
        data-computed="<?php echo json_encode(ElementType::COMPUTED_FIELDS)?>"
        data-enums="<?php echo json_encode(ElementType::HAS_ENUM_ATTRIBUTES)?>""
        >
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $this->title ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'description')->textInput() ?>
    <?= $form->field($model, 'nameEng')->textInput() ?>
    <?= $form->field($model, 'descriptionEng')->textInput() ?>                            
    <?php if (!$formId): ?>                        
        <?= $form->field($model, 'formId')->dropDownList($model->formsList()) ?>
    <?php else: ?>   
       <?php echo $form->field($model,'formId')->hiddenInput()->label(false) ;?>                      
    <?php endif; ?> 
    <?= $form->field($model, 'elementTypeId',['inputOptions' => [
        'id' => 'element-type-selector',
        'class' => 'form-control'
        ]])
            ->dropDownList($model->elementTypesList()) ?>                        
    <?= $form->field($model, 'fieldGroupId')->dropDownList($model->fieldGroupList()) ?>
    <?= $form->field($model, 'order')->textInput() ?>
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Дополнительные параметры</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
    <div id="required-block"<?php if (!in_array($model->elementTypeId, ElementType::HAS_REQUIRED)):?> class="hide"<?php endif; ?>>
        <?= $form->field($model->parameters, 'required')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => 'Да',
                        'offText' => 'Нет',
                    ]
            ]) 
        ?>
    </div>
    <div id="number-params"<?php if (!in_array($model->elementTypeId, ElementType::NUMBER_PARAMS)):?> class="hide"<?php endif; ?>>
        <?= $form->field($model->parameters, 'unit')->dropDownList($model->unitsList()) ?>                            
    </div>
    <div id="computed"<?php if (!in_array($model->elementTypeId, ElementType::COMPUTED_FIELDS)):?> class="hide"<?php endif; ?>>
        <?= $form->field($model->parameters, 'isComputed')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => 'Да',
                        'offText' => 'Нет',
                    ],
                'pluginEvents' => [
                    "init.bootstrapSwitch" => "function(e) { console.log('aaaa'); }",
                    "switchChange.bootstrapSwitch" => 
                        "function(e) { e.target.checked ? $('#computed-params__container').removeClass('hide') :
                            $('#computed-params__container').addClass('hide'); }",
                ]             
            ]) 
        ?>
                
        <div id="computed-params__container"<?php if(!$model->parameters->isComputed): ?> class="hide"<?php endif ?>>
            <div id="unit-price__container"<?php if ($model->hasEnums ):?> style="display: none;"<?php endif; ?>>
            <?= $form->field($model->parameters, 'unitPrice')->textInput() ?>
                </div>
        </div>
    </div>                
                            
     <div id="html-params"<?php if (!in_array($model->elementTypeId, ElementType::HTML_BLOCKS)):?> class="hide"<?php endif; ?>>
            <?= $form->field($model->parameters, 'html')->widget(CKEditor::class,[
                'editorOptions' => [
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по умолчанию false
                ],
                ]) 
            ?>
            <?= $form->field($model->parameters, 'htmlEng')->widget(CKEditor::class,[
                'editorOptions' => [
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по умолчанию false
                ],
                ]) 
            ?>         
        </div>                            
        <div id="text-params"<?php if (!in_array($model->elementTypeId, ElementType::TEXT_BLOCKS)):?> class="hide"<?php endif; ?>>
            <?php echo $form->field($model->parameters, 'text')->textarea(); ?>
            <?php echo $form->field($model->parameters, 'textEng')->textarea(); ?>
        </div>
    </div>
                            
                    </div>
                        
                </div>
            </div>                            
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                        <div id="attribute-enums-wrapper" class="col-md-6<?php if (!$model->hasEnums ):?> hide<?php endif; ?>"> 
                            <?php echo $this->render('enum-elements-table.php',[
                                'enumsList' => $enumsList
                            ]) ?>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
