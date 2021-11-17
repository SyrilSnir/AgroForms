<?php

use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\Forms\Manage\Forms\FormsForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
/* @var $this View */
/* @var $model FormsForm */

$this->title = Yii::t('app/title', 'Edit form') . ': ' . $model->name;
$anotherExhibitions = ArrayHelper::map(Exhibition::find()->andFilterWhere(['!=', 'id', $model->exhibitionId ])->orderBy('id')->asArray()->all(), 'id', 'title');
?>

<div class="update-form">
    <?php if (!empty($anotherExhibitions)): ?>
    <div class="clone-form-block">
        <?php $cloneExhibitionForm = ActiveForm::begin(['action' => ['copy']]); ?>
        <?php echo $cloneExhibitionForm->field($cloneForm, 'exhibitionId')->dropDownList($anotherExhibitions)->label(false); ?>
        <?php echo $cloneExhibitionForm->field($cloneForm, 'formId')->hiddenInput()->label(false); ?>
        <?php echo  Html::submitButton(t('Create copy'),[
             //'id' => 'form-copy',
            'class' => 'btn btn-secondary'
            ]) 
        ?>
        <?php ActiveForm::end(); ?>
    </div>
    <?php endif; ?>    
    <?php echo $this->render('_form', [
        'model' => $model,
        'newForm' => false,
        'formFieldsDataProvider' => $formFieldsDataProvider,
        'formFieldsModel' => $formFieldsModel,    
        'showDeletedForm' => $showDeletedForm           
    ]) ?>
</div>
