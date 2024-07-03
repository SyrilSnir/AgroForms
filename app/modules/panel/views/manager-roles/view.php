<?php

use app\models\ActiveRecord\Users\ManagerRoleRules;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model ManagerRoleRules */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->name;
?>
<div class="view">
    <p>
        <?= Html::a(Yii::t('app', 'Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete the role?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>
    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name:text:' . Yii::t('app', 'Role'),
                ],
            ]); ?>
        </div>
    </div>
    <?php echo $this->render('rules-list', [
            'model' => $model,
            'provider' => $tplVars['rulesProvider'],
            'searchModel' => $tplVars['searchModel'],
            'roleId' => $tplVars['roleId'],
        ]) 
    ?>
</div>

