<?php

use app\models\Forms\Manage\Forms\StandForm;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this */
/** @var ActiveForm $form */
/** @var StandForm $model */
/** @var bool $newModel */

if (!$model->imageFile) {
    $pluginOptions = [];
} else {
    $pluginOptions = [
        'showRemove' => false,
        'initialPreview'=>[
             $model->imageFile
        ],
        'initialPreviewAsData'=>true,
    ];
}
?>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>
    <?php //if($newModel) :?>
    <?php echo $form->field($model, 'formId')->dropDownList($model->formsList()); ?>
    <?php // else: ?>
        <?php // echo $form->field($model, 'formId')->hiddenInput()->label(false) ?>
    <?php // endif; ?>
                            
    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(),[
                'editorOptions' => [
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по умолчанию false
                ],

            ]); 
    ?> 
    <?= $form->field($model, 'nameEng')->textInput() ?>

    <?= $form->field($model, 'descriptionEng')->widget(CKEditor::className(),[
                'editorOptions' => [
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по умолчанию false
                ],

            ]); 
    ?>                             
    <?= $form->field($model, 'price')->textInput()->label(Html::decode($model->getAttributeLabel('price'))) ?>
    <?= $form->field($model, 'photo')->widget(FileInput::class, 
        [
            'options' => [
                'accept' => 'image/*',
                'multiple' => false
            ],
            'pluginOptions' => $pluginOptions
        ])
    ?>                            

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/title', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/title', 'Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
