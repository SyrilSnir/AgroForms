<?php

use app\models\Forms\Manage\Forms\FormTypeForm;
use yii\web\View;



/** @var View $this  */
/** @var FormTypeForm $model  */

$this->title = 'Новый тип формы';
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

