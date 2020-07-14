<?php

use app\models\ActiveRecord\Forms\FormType;
use app\models\Forms\Manage\Forms\FormsForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this */
/** @var ActiveForm $form */
/** @var FormsForm $model */
$dynamicFormId = FormType::DYNAMIC_ORDER_FORM;
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
<?= $form->field($model, 'order')->textInput() ?>

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