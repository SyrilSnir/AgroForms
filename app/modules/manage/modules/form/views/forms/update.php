<?php
/* @var $this yii\web\View */

$this->title = 'Редактирование формы';
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
