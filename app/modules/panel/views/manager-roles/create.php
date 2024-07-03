<?php

use app\models\ActiveRecord\Users\ManagerRoles;
use yii\web\View;

/** @var View $this  */
/** @var ManagerRoles $model  */

$this->title = Yii::t('app/title', 'New role') ;
?>

<div class="create-form">
    
<?php echo $this->render('_form', [
        'model' => $model,
]) ?>

</div>

