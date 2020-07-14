<?php

use app\models\Forms\Manage\Forms\FieldForm;
use yii\web\View;



/** @var View $this  */
/** @var FieldForm $model  */

$this->title = 'Новое поле';
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
        'formId' => $formId
]) ?>

</div>

