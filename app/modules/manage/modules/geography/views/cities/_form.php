<?php

use app\models\Forms\Geography\CityForm;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var ActiveForm $form */
/** @var CityForm $model */
?>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">                           
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxLength' => true]) ?>
    <?= $form->field($model, 'nameEng')->textInput(['maxLength' => true]) ?>
    <?= $form->field($model, 'countryId')->widget(Select2::class,
    [
        'data' => $model->countriesList(),
        'options' => [ 'id' => 'l_country' ],
    ])
   ?>
    <?= $form->field($model, 'region')->widget(DepDrop::class,
    [
        'data' => $model->regionsList(),
        'type' => DepDrop::TYPE_SELECT2,
        'options' => [ 'id' => 'l_region' ],
        'pluginOptions' => [
            'depends' => ['l_country'],
            'placeholder' => 'Select...',
            'url' => '/api/geography/get-regions'
        ]                            
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
