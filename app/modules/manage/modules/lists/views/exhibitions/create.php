<?php

use app\models\Forms\Manage\Exhibition\ExhibitionForm;
use yii\web\View;



/** @var View $this  */
/** @var ExhibitionForm $model  */

$this->title = 'Новая выставка';
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

