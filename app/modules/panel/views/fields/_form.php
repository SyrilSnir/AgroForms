<?php

use app\models\ActiveRecord\Forms\ElementType;
use app\models\Forms\Manage\Forms\FieldForm;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use function GuzzleHttp\json_encode;



/** @var View $this */
/** @var ActiveForm $form */
/** @var FieldForm $model */
/** @var int|null $formId */
/** @var bool $isNew */

if (!$isNew) {
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> 
                                Html::a('<i class="fas fa-plus"></i>',['special-price/create', 'fieldId' => $model->id], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app', 'Add special price rules'),
                                ])                            
                        ],
                    ],      
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'start_date',
                            'format' => 'date',
                            'value' => 'start_date',
                            'label' => Yii::t('app', 'Start date'),
                        ],
                        [
                            'attribute' => 'end_date',
                            'format' => 'date',
                            'value' => 'end_date',
                            'label' => Yii::t('app', 'End date'),                            
                        ],                         
                        'price:text:' . Yii::t('app', 'Value'),
                        [
                            'class' => ActionColumn::class,
                            'controller' => 'special-price'
                        ],
                    ],    
    ];
$gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';
$fullGridConfig = array_merge($columnsConfig,$gridConfig);     
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
        data-enums="<?php echo json_encode(ElementType::HAS_ENUM_ATTRIBUTES)?>"
        data-equipment="<?php echo json_encode(ElementType::ELEMET_ADDITIONAL_EQUIPMENT)?>"
        data-group="<?php echo json_encode(ElementType::ELEMENT_GROUP)?>"
        data-frieze="<?php echo json_encode(ElementType::ELEMENT_FRIEZE) ?>"
        data-datetime="<?php echo json_encode(ElementType::ELEMENT_DATE_TIME) ?>"
        >
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'description')->textInput() ?>
    <?= $form->field($model, 'nameEng')->textInput() ?>
    <?= $form->field($model, 'descriptionEng')->textInput() ?>                            
    <?php if (!$model->formId): ?>                        
        <?= $form->field($model, 'formId')->dropDownList($model->formsList()) ?>
    <?php else: ?>   
       <?php echo $form->field($model,'formId')->hiddenInput()->label(false) ;?>                      
    <?php endif; ?> 
                            
    <?php if ($isNew):?>
        <?= $form->field($model, 'elementTypeId',['inputOptions' => [
            'id' => 'element-type-selector',
            'class' => 'form-control'
            ]])
                ->dropDownList($model->elementTypesList()) ?>                        
    <?php endif; ?>
        <?= $form->field($model, 'showInRequest')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => Yii::t('app', 'Yes'),
                        'offText' => Yii::t('app', 'No'),
                    ]
            ]) 
        ?> 
        <?= $form->field($model, 'showInPdf')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => Yii::t('app', 'Yes'),
                        'offText' => Yii::t('app', 'No'),
                    ]
            ]) 
        ?>
        <?= $form->field($model, 'toExport')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => Yii::t('app', 'Yes'),
                        'offText' => Yii::t('app', 'No'),
                    ]
            ]) 
        ?>                            
    <?php // $form->field($model, 'order')->textInput() ?>
                           
    <?php echo $form->field($model, 'fieldGroupId')->dropDownList($model->fieldGroupsList()) ?>

    <?php // echo $form->field($model, 'fieldGroupId')->hiddenInput(['value' => 0])->label(false) ?>
    <?php // $form->field($model, 'order')->textInput() ?>
<?php if (true/*$isNew*/): ?>
            <div id="field-options" class="card card-default">
                <div class="card-header">
                  <h3 class="card-title"><?= Yii::t('app', 'Extra options') ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
    <div class="col-12">
        <div id="required-block"<?php if (!in_array($model->elementTypeId, ElementType::HAS_REQUIRED)):?> class="hide"<?php endif; ?>>
            <?= $form->field($model->parameters, 'required')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => Yii::t('app', 'Yes'),
                            'offText' => Yii::t('app', 'No'),
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
                            'onText' => Yii::t('app', 'Yes'),
                            'offText' => Yii::t('app', 'No'),
                        ],
                    'pluginEvents' => [
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
                <?php if (!$isNew): ?>
                <div class="special-price-params__container">
                    <h5><?php echo t('Special price rules')?> </h5>
                <section class="content">
                    <div class="card">
                        <div class="card-body">
                                <?= $form->field($model->parameters, 'specialPriceType')->dropDownList($model->parameters->getSpecialPriceTypes()) ?> 
                                <?= GridView::widget($fullGridConfig); ?>
                        </div>
                    </div>
                </section>                
                </div>
                <?php endif ;?>
            </div>
        </div>                
                            
        <div id="html-params"<?php if (!in_array($model->elementTypeId, ElementType::HTML_BLOCKS)):?> class="hide"<?php endif; ?>>
            <?= $form->field($model->parameters, 'html')->widget(CKEditor::class,[
                'editorOptions' => 
                ElFinder::ckeditorOptions('elfinder', [
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false,                    
                ])
                ]) 
            ?>
            <?= $form->field($model->parameters, 'htmlEng')->widget(CKEditor::class,[
                'editorOptions' => 
                ElFinder::ckeditorOptions('elfinder', [
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false,                    
                ])
                /*[
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по умолчанию false
                ],*/
                ]) 
            ?>         
        </div>                            
        <div id="text-params"<?php if (!in_array($model->elementTypeId, ElementType::TEXT_BLOCKS)):?> class="hide"<?php endif; ?>>
            <?php echo $form->field($model->parameters, 'text')->textarea(); ?>
            <?php echo $form->field($model->parameters, 'textEng')->textarea(); ?>
        </div>
        <div id="additional-equipment"<?php if ($model->elementTypeId != ElementType::ELEMET_ADDITIONAL_EQUIPMENT):?> class="hide"<?php endif; ?>>
            <?= $form->field($model->parameters, 'allCategories')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => Yii::t('app', 'Yes'),
                            'offText' => Yii::t('app', 'No'),
                        ],
                    'pluginEvents' => [
                        "switchChange.bootstrapSwitch" => 
                            "function(e) { !e.target.checked ? $('#equipment-params__container').removeClass('hide') :
                                $('#equipment-params__container').addClass('hide'); }",
                    ]             
                ])                 
            ?>
            <div id="equipment-params__container"<?php if($model->parameters->allCategories): ?>class="hide"<?php endif; ?>>
                <?php 
                    echo $form->field($model->parameters, 'categories')->widget(
                            Select2::class,
                            [
                                'data' =>  $model->parameters->categoriesList(),
                                 'options' => [ 'multiple' => true ],
                            ]
                        );                
                ?>
            </div>
        </div> 
        <div id="frieze-params"<?php if ($model->elementTypeId != ElementType::ELEMENT_FRIEZE):?> class="hide"<?php endif; ?>>
            <?= $form->field($model->parameters, 'freeDigitCount')->textInput() ?>      
            <?= $form->field($model->parameters, 'digitPrice')->textInput() ?>  
        </div>
        <div id="group-params"<?php if($model->elementTypeId != ElementType::ELEMENT_GROUP): ?> class="hide"<?php endif; ?>>
            <?= $form->field($model->parameters, 'groupType')->dropDownList($model->parameters->groupTypesList() ) ?>
        </div>
                            
    </div>
                            
                    </div>
                        
                </div>
            </div>  
 
            <?php elseif ($model->parameters->isComputed): ?>
                <div class="special-price-params__container">
                    <h5><?php echo t('Special price rules')?> </h5>
                <section class="content">
                    <div class="card">
                        <div class="card-body">
                                <?= $form->field($model->parameters, 'specialPriceType')->dropDownList($model->parameters->getSpecialPriceTypes()) ?> 
                                <?= GridView::widget($fullGridConfig); ?>
                        </div>
                    </div>
                </section>                
                </div>
                <?php endif ;?>                            
                            
                            
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), [$previousPage], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                        <div id="attribute-enums-wrapper" class="col-md-6<?php if (!$model->hasEnums ):?> hide<?php endif; ?>"> 
                            <div id="attributes-enum-list" class="card">
                                          <div class="card-header">
                                              <h3 class="card-title"><?php echo t('Enumerated items') ?></h3>
                                          </div>
                                          <!-- /.card-header -->              

                            <div class="card-body">                            
                            <?php if(!$isNew): ?>
                            <?php echo $this->render('enum-elements-table.php',[
                                'enumsList' => $enumsList,
                                'enumsForm' => $enumsForm                                 
                            ]) ?>
                            <?php else: ?>
                                <p style="color:red"><?php echo t('Adding list items will be available after saving the field') ?></p>
                            <?php endif; ?>
                            </div>
                            </div>
                            
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
