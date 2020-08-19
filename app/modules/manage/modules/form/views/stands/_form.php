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
                <div class="card-header">
                    <h3 class="card-title"><?php echo $this->title ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

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
    <?= $form->field($model, 'price')->textInput() ?>                            
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
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
