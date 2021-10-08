<?php

use app\core\helpers\View\Form\FormStatusHelper;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\FormType;
use app\models\Forms\Manage\Forms\FormsForm;
use dosamigos\multiselect\MultiSelectListBox;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use kartik\switchinput\SwitchInput;
use kotchuprik\sortable\grid\Column;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this */
/** @var ActiveForm $form */
/** @var FormsForm $model */
$dynamicFormId = FormType::DYNAMIC_ORDER_FORM;
$exhibitions = $model->getExhibitionsList();
?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">                           
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'nameEng')->textInput() ?>
<?= $form->field($model, 'title')->textInput() ?>
<?= $form->field($model, 'titleEng')->textInput() ?>
<?= $form->field($model, 'slug')->textInput() ?>
 <?php 
echo $form->field($model, 'description')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],

    ]);
echo $form->field($model, 'descriptionEng')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],

    ]);    
?>                           

<?= $form->field($model, 'formType',[
        'options' => [
            'onchange' => "(function(e) { $(e.target).find('option:selected').val() == {$dynamicFormId} ? $('#price-block').removeClass('hide') :
                        $('#price-block').addClass('hide'); })(event)"
        ]
    ])->dropDownList($model->formTypesList()) ?>
<div id="price-block"<?php if (!($model->formType == $dynamicFormId)):?> class="hide"<?php endif; ?>>
    <?= $form->field($model, 'basePrice')->textInput() ?>                            
</div>                            
<?= $form->field($model, 'status')->dropDownList(FormStatusHelper::statusList()) ?>

<?= $form->field($model, 'hasFile')->widget(SwitchInput::class,[
                'pluginOptions' => [
                        'onText' => Yii::t('app','Yes'),
                        'offText' => Yii::t('app','No'),
                    ]
    ]);
    ?>
<?php if (!empty($exhibitions)):?>
<?php  echo $form->field($model, 'exhibitionsList')->widget(MultiSelectListBox::className(),[
    'data' => $exhibitions,
    'options' => [
        'multiple'=>"multiple"
    ],
    'clientOptions' => [
    ]
])  ?> 
                        <?php endif; ?> 
<?= $form->field($model, 'valute')->dropDownList($model->getValutesList()) ?>                        
                       
<div class="form-group">
    <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app','Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
</div>
<?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>

<?php if (in_array($model->formType, FormType::HAS_DYNAMIC_FIELDS)): ?>
<?php 
$columnsConfig = [
                    'toolbar' => [
                        [
                            'header' => 'rrrgrg',
                            'content'=> //$rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['fields/create', 'formId' => $model->id], [
                                    'class' => 'btn btn-sm btn-success',
                                ])                            
                        ],
                    ],
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => Yii::t('app','List of fields')
                    ],
                    'dataProvider' => $formFieldsDataProvider,
                    'filterModel' => $formFieldsModel,
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        return ['data-sortable-id' => $model->id];
                    },    
                    'columns' => [  
                        [
                            'class' => Column::className(),
                        ],                        
                        'name:text:' . Yii::t('app','Name'),
                        /**[
                            'label' => Yii::t('app','Group'),
                            'filter' => $formFieldsModel->fieldGroupList(),
                            'attribute' => 'fieldGroupId',
                            'value' => function (Field $model) {
                                return $model->fieldGroup ? $model->fieldGroup->name:
                                        Yii::t('app','Undefined');
                            }
                        ],*/
                        'description:text:' . Yii::t('app','Description'),
                        
                        [
                            'label' => Yii::t('app','Element type'),
                            'attribute' => 'elementTypeId',
                            'filter' => $formFieldsModel->elementTypesList(),
                            'value' => function (Field $model) {
                                    return $model->elementType->name;
                                }
                            ],
                        [
                            'class' => ActionColumn::class,
                           // 'header' => 'Действия',
                            'controller' => 'fields'                       
                        ],
                    ],  
                    'options' => [
                        'data' => [
                            'sortable-widget' => 1,
                            'sortable-url' => Url::toRoute(['fields-sorting']),
                        ]
                    ],                                      
    ];
$gridConfig = []; //require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';    
$fullGridConfig = array_merge($gridConfig, $columnsConfig);
?>
    <div class="card">
        <div class="card-body">
            <?= GridView::widget($fullGridConfig); ?>
        </div>
    </div>  
<?php endif; ?>        
        
    </div>
</section>