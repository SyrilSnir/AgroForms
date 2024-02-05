<?php
/* @var $this yii\web\View */

$this->title = 'Редактирование выставки';
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
        'isUpdate' => $tplVars['isUpdate'],
        'contractId' => $tplVars['contractId'],
        'mediaFeeDataProvider' => $tplVars['mediaFeeDataProvider']
    ]) ?>
</div>
