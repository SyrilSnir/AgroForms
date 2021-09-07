<?php

use app\models\Forms\Common\ValuteForm;
use yii\web\View;



/** @var View $this  */
/** @var ValuteForm $model  */

$this->title = Yii::t('app/title', 'New valute');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

