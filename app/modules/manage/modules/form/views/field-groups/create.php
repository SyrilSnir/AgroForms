<?php

use app\models\Forms\Manage\Forms\FieldForm;
use yii\web\View;



/** @var View $this  */
/** @var FieldForm $model  */

$this->title = 'Новая группа';
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

