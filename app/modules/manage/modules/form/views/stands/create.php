<?php

use app\models\Forms\Manage\Forms\StandForm;
use yii\web\View;



/** @var View $this  */
/** @var StandForm $model  */

$this->title = 'Новый тип стенда';
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

