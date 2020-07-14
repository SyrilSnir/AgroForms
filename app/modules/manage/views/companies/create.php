<?php

use app\models\Forms\Nomenclature\EquipmentForm;
use yii\web\View;



/** @var View $this  */
/** @var EquipmentForm $model  */

$this->title = 'Новая компания';
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

