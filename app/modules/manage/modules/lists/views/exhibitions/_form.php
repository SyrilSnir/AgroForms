<?php

use app\models\Forms\Manage\Exhibition\ExhibitionForm;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this */
/** @var ActiveForm $form */
/** @var ExhibitionForm $model */
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

    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'titleEng')->textInput() ?>
    <?= $form->field($model, 'description')->textInput() ?>
    <?= $form->field($model, 'descriptionEng')->textInput() ?>
    <?= $form->field($model, 'startDate')->widget(DatePicker::class, [
           'options' => ['placeholder' => ''],
            'value' => $model->startDate,
            'removeButton' => false,
            'pickerIcon' => false,
           'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]); ?>
    <?= $form->field($model, 'endDate')->widget(DatePicker::class, [
           'options' => ['placeholder' => ''],
            'value' => $model->endDate,
            'removeButton' => false,
            'pickerIcon' => false,
           'pluginOptions' => [
               'autoclose'=>true,
               'format' => 'dd.mm.yyyy'
           ]
       ]);?>
                            
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
