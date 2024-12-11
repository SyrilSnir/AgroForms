<?php

use app\models\ActiveRecord\Forms\FieldEnum;
use kartik\grid\ActionColumn;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kotchuprik\sortable\grid\Column;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap4\ActiveForm;

/** @var array $enumsList */
/** @var FieldEnum $model */
/** @var View $this */

?>

        <?php 
    $dataProvider = new ArrayDataProvider([
        'allModels' => $enumsList,
    ]);
    echo GridView::widget([
        'columns' => [
            [
                'class' => Column::className(),
            ],            
            [
                'class'=> EditableColumn::class,
                'attribute'=>'name',
                'value' => function (FieldEnum $model) {
                    $model->disableMultilang();
                    return $model->name;
                },
                'filterInputOptions' => [
                    'class' => 'nnnn',
                ],
                'editableOptions' => function ($model, $key, $index) {
                    return [                
                        'editableValueOptions'=>['class'=>'element-name kv-editable-link'],
                        'formOptions' => [
                            'action' => Url::toRoute(['/api/enum-elements/edit','id' => $model->id])
                        ]  
                    ];
                }
                               
            ],
            [
                'class'=> EditableColumn::class,
                'attribute'=>'name_eng',
                'editableOptions' => function ($model, $key, $index) {
                    return [                
                        'formOptions' => [
                            'action' => Url::toRoute(['/api/enum-elements/edit','id' => $model->id])
                        ]  
                    ];
                }                
                
            ],
            [
                'class'=> EditableColumn::class,
                'attribute'=>'value',
                'editableOptions' => function ($model, $key, $index) {
                    return [                
                        'editableValueOptions'=>['class'=>'element-value kv-editable-link'],                        
                        'formOptions' => [
                            'action' => Url::toRoute(['/api/enum-elements/edit','id' => $model->id])
                        ]  
                    ];
                }                
            ],  
            [
                'class' => ActionColumn::class,
                'controller' => 'field-enum',
                'visibleButtons' => [
                    'update' => false,
                    'view' => false
                ]
            ]
            
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-sortable-id' => $model->id];
        },  
        'options' => [
            'data' => [
                'sortable-widget' => 1,
                'sortable-url' => Url::toRoute(['enums-sorting']),
            ]
        ],                 
        'dataProvider' => $dataProvider
        
    ]);
        ?>
                              <?php 
                            $newEnumItemForm = ActiveForm::begin([
                                'enableClientValidation' => false
                            ]);
                          ?>
    
                  <div class="container">
                      <div class="row align-items-end">
    <?= $newEnumItemForm->field($enumsForm, 'fieldId')->hiddenInput(['maxLength' => true])->label(false) ?>
                          <div class="col-4">
    <?= $newEnumItemForm->field($enumsForm, 'name')->textInput(['maxLength' => true])->error(false) ?>
                          </div>
                          <div class="col-4">
    <?= $newEnumItemForm->field($enumsForm, 'nameEng')->textInput(['maxLength' => true])->error(false) ?>
                          </div>                            
                          <div class="col-4">
    <?= $newEnumItemForm->field($enumsForm, 'value')->textInput(['maxLength' => true])->error(false) ?>
                          </div>                        
                          <div class="col-3 align-items-end">
        <?= Html::submitButton(Yii::t('app','Add'), ['class' => 'btn btn-block btn-success enum-field-add-button']) ?>                             
                          </div>

                      </div>
        <?php
        $field = \app\models\ActiveRecord\Forms\Field::findOne($enumsForm->fieldId);
        $defVal = $field->default_value;
                

        ?>
                      <div class="row align-items-end">
                          <div class="field-default-selector"><p>Значение по умолчанию</p>
                              <select name="def-value" id="default-value-selector" data-default="<?= $defVal ?>">
                          </select>
                              <button id="set-default-value" data-field="<?php echo $enumsForm->fieldId ?>" type="button" class="btn btn-sm ml-2 btn-info">Установить</button>
                              </div>
                      </div>
                  </div> 
                  
                              <?php  ActiveForm::end(); ?>


