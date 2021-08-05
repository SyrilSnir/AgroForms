<?php

use app\models\Forms\Nomenclature\UnitForm;
use yii\web\View;



/** @var View $this  */
/** @var UnitForm $model  */

$this->title = Yii::t('app','New element type of form');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

