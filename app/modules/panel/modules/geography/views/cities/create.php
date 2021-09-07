<?php

use app\models\Forms\Manage\Geografy\CountryForm;

/** @var yii\web\View $this  */
/** @var CountryForm $model  */

$this->title = Yii::t('app/title','New city');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

