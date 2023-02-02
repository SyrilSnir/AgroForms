<?php

use app\models\Forms\Nomenclature\RubricatorForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;



/** @var View $this */
/** @var ActiveForm $form */
/** @var RubricatorForm $model */
/** @var bool $isUpdate */
?>
<div class="card card-default">
    <div class="card-header">
        <?php if(!$isUpdate): ?>
        <h3 class="card-title"><?php echo t('New section') ?></h3>
        <?php else: ?>
        <h3 class="card-title"><?php echo $model->name ?></h3>
        <?php endif; ?>
    </div>                
    <div class="card-body">
    <?php $form = ActiveForm::begin(['action' => $isUpdate ? 'update?id='. $model->id : 'create' ]); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'nameEng')->textInput() ?>
    <?= $form->field($model, 'order')->textInput() ?>
                            
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
