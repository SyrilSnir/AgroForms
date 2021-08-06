<?php

use app\models\Forms\Nomenclature\EquipmentGroupForm;
use yii\web\View;



/** @var View $this  */
/** @var EquipmentGroupForm $model  */

$this->title = Yii::t('app/title','New category');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

