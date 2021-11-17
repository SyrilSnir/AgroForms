<?php

use app\models\Forms\Manage\Forms\FormsForm;
use yii\web\View;



/** @var View $this  */
/** @var FormsForm $model  */

$this->title = Yii::t('app/title', 'New form');
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
        'newForm' => true
]) ?>

</div>

