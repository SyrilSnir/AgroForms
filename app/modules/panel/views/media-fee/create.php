<?php

use app\models\Forms\Manage\Contract\ContractMediaFeeForm;
use yii\web\View;

/** @var View $this  */
/** @var ContractMediaFeeForm $model  */

$this->title = Yii::t('app/title','New media contribution');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

