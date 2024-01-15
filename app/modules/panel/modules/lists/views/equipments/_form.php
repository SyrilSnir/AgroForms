<?php

use app\models\Forms\Nomenclature\EquipmentForm;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this */
/** @var ActiveForm $form */
/** @var EquipmentForm $model */
/** @var bool $isUpdate  */
/** @var ActiveDataProvider $pricesDataProvider  */

if ($isUpdate) {
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> 
                                Html::a('<i class="fas fa-plus"></i>',['equipment-price/create','equipmentId' => $equipmentId], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app/equipment', 'Add price for exhibition'),
                                ])                            
                        ],
                    ],      
                    'dataProvider' => $pricesDataProvider,
                    'columns' => [ 
                        
                        'exhibition.title:text:' . Yii::t('app', 'Exhibition'),
                        'price:text:' . Yii::t('app', 'Price'),
                        [
                            'class' => ActionColumn::class,
                            'controller' => 'equipment-price',
                             'visibleButtons' => [
                                'view' => false,
                                'delete' => false,
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

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'description')->textInput() ?>
    <?= $form->field($model, 'nameEng')->textInput() ?>
    <?= $form->field($model, 'descriptionEng')->textInput() ?>                            
    <?= $form->field($model, 'code')->textInput() ?>
    <?= $form->field($model, 'groupId')->dropDownList($model->categoriesList()) ?>                         
    <?= $form->field($model, 'unitId')->dropDownList($model->unitsList()) ?>                         
    <?= $form->field($model, 'price')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($isUpdate) :?>
            <div class="price-params__container">
                    <h5><?php echo t('Prices')?> </h5>
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
