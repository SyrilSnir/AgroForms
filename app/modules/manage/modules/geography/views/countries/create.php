<?php

use app\models\Forms\Geography\RegionForm;
use yii\web\View;

/** @var View $this  */
/** @var RegionForm $model  */

$this->title = 'Новая страна';
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

