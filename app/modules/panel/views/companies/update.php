<?php

use app\models\Forms\Manage\Companies\CompanyForm;
use yii\web\View;
/* @var $this View */
/** @var CompanyForm $model */

$this->title = Yii::t('app/title', 'Edit company') . ': ' . $model->name;
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
        'isUpdate' => true,
    ]) ?>
</div>
