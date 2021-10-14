<?php

use app\models\Forms\Manage\Forms\FieldForm;
use yii\web\View;



/** @var View $this  */
/** @var FieldForm $model  */

$this->title = Yii::t('app/title', 'New field');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
        'formId' => $formId,
        'enumsList' => $enumsList,
        'isNew' => true,
        'previousPage' => $previousPage, 
        
]) ?>

</div>

