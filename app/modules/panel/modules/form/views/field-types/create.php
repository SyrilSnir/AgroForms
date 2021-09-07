<?php

use app\models\Forms\Nomenclature\UnitForm;
use yii\web\View;



/** @var View $this  */
/** @var UnitForm $model  */

$this->title = 'Новая единица измерения';
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

