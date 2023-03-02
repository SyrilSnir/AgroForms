<?php

use app\core\helpers\Data\RubricatorHelper;
use app\models\ActiveRecord\Nomenclature\Rubricator;
use app\models\Forms\Nomenclature\RubricatorForm;
use kartik\select2\Select2;
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
    <?php $form = ActiveForm::begin(['action' => $isUpdate ? '/panel/lists/rubricator/update?id='. $model->id : '/panel/lists/rubricator/create' ]); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'nameEng')->textInput() ?>
    <?php if($model->id != 1): ?>
    <?= $form->field($model, 'parentId')->widget(Select2::class,[
        'data' => RubricatorHelper::getHierarchicalList()
            ]) ?>
    <?php endif; ?>                
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-primary']) ?>
        <?php if($isUpdate): ?>
            <?php 
                $rubricator = Rubricator::findOne($model->id);
                $messageText = $rubricator->isLeaf() ? 
                        t('Are you sure you want to delete the section?') : 
                        t('Are you sure you want to delete the section with all child subsections?')
            
            ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => $messageText,
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app','Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
