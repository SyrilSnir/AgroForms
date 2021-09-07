<?php
/* @var $this yii\web\View */

$this->title = Yii::t('app/title', 'Change form type');
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
