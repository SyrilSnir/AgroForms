<?php
/* @var $this yii\web\View */

$this->title = Yii::t('app/title', 'Edit role') . ': ' . $model->name;
?>

<div class="update-form">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?php echo $this->render('rules-list', [
            'model' => $model,
            'provider' => $tplVars['rulesProvider'],
            'searchModel' => $tplVars['searchModel'],
            'roleId' => $tplVars['roleId'],
        ]) 
    ?>
</div>
