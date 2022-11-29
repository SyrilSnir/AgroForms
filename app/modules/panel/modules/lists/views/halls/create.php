<?php

use app\models\Forms\Manage\Contract\HallForm;
use yii\web\View;



/** @var View $this  */
/** @var HallForm $model  */

$this->title = Yii::t('app/title','New hall');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

