<?php

use app\models\Forms\Nomenclature\EquipmentPricesForm;
use yii\web\View;



/** @var View $this  */
/** @var EquipmentPricesForm $model  */

$this->title = Yii::t('app/title','New price');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
        'isUpdate' => $isUpdate
]) ?>

</div>

