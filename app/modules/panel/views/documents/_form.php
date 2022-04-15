<?php

use app\models\Forms\Manage\Document\DocumentForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this */
/** @var ActiveForm $form */
/** @var DocumentForm $model */
?>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'titleEng')->textInput() ?>
    <?= $form->field($model, 'description')->textarea() ?>
    <?= $form->field($model, 'descriptionEng')->textarea() ?>
    <?= $form->field($model, 'companyId')->widget(Select2::class,[
        'data' => $model->companiesList()
            ]) ?>   
    <?= $form->field($model, 'exhibitionId')->dropDownList($model->getExhibitionsList()) ?> 

    <?= $form->field($model, 'file')->widget(FileInput::class, 
        [
            'options' => [
                //'accept' => 'image/*',
                'multiple' => false,                
            ],
            'pluginOptions' => [
                'layoutTemplates' => [
                    'footer' => '
                        <div class="file-thumbnail-footer">
                        <div class="file-caption-name"></div>
                        </div>
                    ',
                ],
                'showCancel' => false,
                'showRemove' => false,                
                'initialPreview'=> [
                   $model->fileUrl
                ],                
                'initialPreviewAsData'=>false,                
            ],
            'pluginEvents' => [
                'filebeforedelete' => 'function() {
                   alert("ok");
                }',
            ]
           // 'pluginOptions' => $pluginOptions
        ])
    ?>                             
                            
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
