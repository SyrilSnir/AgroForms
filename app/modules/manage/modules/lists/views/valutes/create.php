<?php

use app\models\Forms\Common\ValuteForm;
use yii\web\View;



/** @var View $this  */
/** @var ValuteForm $model  */

$this->title = 'Новая валюта';
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

