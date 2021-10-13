<?php

use app\models\Forms\Manage\Forms\SpecialPriceForm;
use yii\web\View;

/** @var View $this  */
/** @var SpecialPriceForm $model  */

$this->title = Yii::t('app/title','New price rule');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

