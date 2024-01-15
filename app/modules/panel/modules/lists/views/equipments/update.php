<?php

use yii\data\ActiveDataProvider;
use yii\web\View;

/* @var $this View */
/** @var bool $isUpdate  */
/** @var ActiveDataProvider $pricesDataProvider  */

$this->title = Yii::t('app/title','Edit equipment');
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
        'isUpdate' => $isUpdate,
        'equipmentId' => $equipmentId,
        'pricesDataProvider' => $pricesDataProvider
    ]) ?>
</div>
