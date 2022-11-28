<?php

use app\models\Forms\Requests\ExcelLoadForm;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this  */
/** @var ExcelLoadForm $model  */

$this->title = Yii::t('app/title','Data load');
?>

<div class="update-form">
    <section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6"> 
   <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'exhibitionId')->widget(
                        Select2::class,
            [
                'data' => $model->getExhibitionsList(true),
                'options' => [ 'id' => 'exhibition' ],
            ]
            )
           ?>
    
    <?=  $form->field($model, 'formId')->widget(
            DepDrop::class,
            [
                'data' => $model->formsList(),
                'type' => DepDrop::TYPE_SELECT2,
                'pluginOptions' => [
                    'depends' => ['exhibition'],
                    'placeholder' => 'Select...',
                    'url' => '/api/exhibition/get-forms'
                ]
            ]
            )
    ?> 
        <?= Html::submitButton(Yii::t('app','Save to Excel'), ['class' => 'btn btn-primary']) ?>                    
   <?php ActiveForm::end(); ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
