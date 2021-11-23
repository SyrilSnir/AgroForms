<?php
/* @var $this yii\web\View */

$this->title = Yii::t('app/title','Edit field');
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
        'enumsList' => $enumsList,
        'enumsPresent' => $enumsPresent,
        'formId' => null,
        'isNew' => false,                    
        'dataProvider' => $dataProvider,
        'previousPage' => $previousPage, 
        'enumsForm' => $enumsForm        
    ]) ?>
</div>
