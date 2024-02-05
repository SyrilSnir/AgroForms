<?php

use app\core\helpers\View\Contract\ContractStatusHelper;
use app\models\Forms\Manage\Contract\ContractForm;
use kartik\date\DatePicker;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;

$selectExpression = new JsExpression('
                    function(e) { 
                        var $selector = $(e.currentTarget);
                        var $selectedElement = $selector.find("option:selected");
                        if ($selectedElement.data("select2-tag") == true) {
                            $.post("/api/hall/save",{
                                "val" : $selectedElement.val()
                            }, function(data) {
                                $selectedElement.val(data.id);
                                console.log($selectedElement);
                            });
                            
                        }
                        
                    }');
$selectExpression2 = new JsExpression('
                    function(e) { 
                        var $selector = $(e.currentTarget);
                        var $selectedElement = $selector.find("option:selected");
                        if ($selectedElement.data("select2-tag") == true) {
                            $.post("/api/stand-number/save",{
                                "val" : $selectedElement.val()
                            }, function(data) {
                                $selectedElement.val(data.id);
                                console.log($selectedElement);
                            });
                            
                        }
                        
                    }');

/** @var View $this */
/** @var ActiveForm $form */
/** @var ContractForm $model */
/** @var bool $isUpdate */
/** @var ?ActiveDataProvider $mediaFeeDataProvider */

if ($isUpdate) {
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> 
                                Html::a('<i class="fas fa-plus"></i>',['media-fee/create','contractId' => $contractId], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app', 'Add media contribution'),
                                ])                            
                        ],
                    ],      
                    'dataProvider' => $mediaFeeDataProvider,
                    'columns' => [ 
                        'mediaFeeType.name:text:' . Yii::t('app', 'Type of media contributions'),
                        'count:text:' . Yii::t('app', 'Count'),
                        
                        [
                            'class' => ActionColumn::class,
                            'controller' => 'media-fee',
                             'visibleButtons' => [
                                'view' => false,
                            ]  ,                          
                            
                        ],
                    ],    
    ];
$gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';
$fullGridConfig = array_merge($columnsConfig,$gridConfig);     
}
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
    <?= $form->field($model, 'hall')->widget(Select2::class,[
        'data' => $model->hallsList(),
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10,        
        ], 
        'pluginEvents' => [
            'select2:select' => $selectExpression,
        ]
    ]) ?>                             
    <?= $form->field($model, 'standNumber')->widget(Select2::class,[
        'data' => $model->standNumbersList(),
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10,        
        ], 
        'pluginEvents' => [
            'select2:select' => $selectExpression2,
        ]
    ]) ?>                               
    <?= $form->field($model, 'square')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(ContractStatusHelper::statusList()) ?>                                                        
    <?= $form->field($model, 'isLogo')->widget(SwitchInput::class,[
                    'pluginOptions' => [
                            'onText' => t('Да'),
                            'offText' => t('Нет'),
                        ]
        ]);
    ?>
    <?= $form->field($model, 'registrationFee')->textInput() ?>                            
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

    <?php 
    
ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
                        <?php if ($isUpdate) :?>
            <div class="fee-types_container">
                    <h5><?php echo t('Media contributions')?> </h5>
                <section class="content">
                    <div class="card">
                        <div class="card-body">
                                <?= GridView::widget($fullGridConfig); ?>
                        </div>
                    </div>
                </section>                
                </div>
            <?php endif; ?>
        </div>
    </section>
