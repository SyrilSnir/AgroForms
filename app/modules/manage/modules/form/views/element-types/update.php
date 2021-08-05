<?php
/* @var $this yii\web\View */

$this->title = Yii::t('app','Edit element type of form');
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
