<?php

use app\models\Forms\Manage\Forms\FormsForm;
use yii\web\View;



/** @var View $this  */
/** @var FormsForm $model  */

$this->title = 'Новая форма';
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

