<?php

use app\models\Forms\Manage\Exhibition\ExhibitionForm;
use yii\web\View;



/** @var View $this  */
/** @var ExhibitionForm $model  */

$this->title = Yii::t('app/title','New contract');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

