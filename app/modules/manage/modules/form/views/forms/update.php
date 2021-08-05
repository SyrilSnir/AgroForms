<?php

use app\models\Forms\Manage\Forms\FormsForm;
use yii\web\View;
/* @var $this View */
/* @var $model FormsForm */

$this->title = Yii::t('app/title', 'Edit form') . ': ' . $model->name;
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
