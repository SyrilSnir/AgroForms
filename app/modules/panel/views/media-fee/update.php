<?php

use app\models\Forms\Manage\Contract\ContractMediaFeeForm;
use yii\web\View;

/** @var View $this  */
/** @var ContractMediaFeeForm $model  */

$this->title = Yii::t('app/title','Edit media contribution');
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
