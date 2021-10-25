<?php

use app\models\Forms\Manage\Forms\StandForm;
use yii\web\View;



/** @var View $this  */
/** @var StandForm $model  */

$this->title = Yii::t('app/title', 'New stand');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
        'newModel' => true
]) ?>

</div>

