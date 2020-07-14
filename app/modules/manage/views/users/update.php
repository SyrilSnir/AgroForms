<?php
/* @var $this yii\web\View */

$this->title = 'Редактирование пользователя';
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
