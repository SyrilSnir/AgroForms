<?php

use app\models\ActiveRecord\Users\ManagerRoleRules;
use yii\web\View;

/* @var $this View */
/* @var $model ManagerRoleRules */

$this->title = Yii::t('app/title', 'Edit rule');
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
