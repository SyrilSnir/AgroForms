<?php
/* @var $this yii\web\View */

$this->title = Yii::t('app/title','Edit price');
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
        'isUpdate' => $isUpdate
    ]) ?>
</div>