<?php

use app\models\Forms\Manage\Contract\StandNumberForm;
use yii\web\View;



/** @var View $this  */
/** @var StandNumberForm $model  */

$this->title = Yii::t('app/title','New number');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

