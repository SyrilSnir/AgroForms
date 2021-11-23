<?php

use kartik\grid\ActionColumn;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use kotchuprik\sortable\grid\Column;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\ActiveRecord\Forms\FieldEnum;

/** @var array $enumsList */
/** @var array FieldEnum $model */
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
                            $newEnumItemForm = ActiveForm::begin();
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
                  </div> 
                  
                              <?php  ActiveForm::end(); ?>


