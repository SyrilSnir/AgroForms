<?php

use app\core\helpers\View\YesNoStatusHelper;
use app\models\ActiveRecord\Users\ManagerRoles;
use kartik\detail\DetailView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model ManagerRoles */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->name;
$attributes = [
                'name:text:' . Yii::t('app', 'Role'),
            ];
if ($model->u_view) {
    $attributes[] = [
                        'group'=>true,
                        'label'=> t('User management'),
                        'rowOptions'=>['class'=>'table-agro-subhead']
                    ]; 
    $attributes[] = [                    
                        'attribute' => 'u_view',
                        'label' => t('View users'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->u_view),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'u_create',
                        'label' => t('Creating an user'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->u_create),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'u_edit',
                        'label' => t('Editing an user'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->u_edit),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'u_delete',
                        'label' => t('Deleting an user'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->u_delete),
                    ];        
}
if ($model->c_view) {
    $attributes[] = [
                        'group'=>true,
                        'label'=> t('Company management'),
                        'rowOptions'=>['class'=>'table-agro-subhead']
                    ];
    $attributes[] = [
                        'group'=>true,
                        'label'=> t('Contract management'),
                        'rowOptions'=>['class'=>'table-agro-subhead']
                    ];
    $attributes[] = [                    
                        'attribute' => 'c_view',
                        'label' => t('View companies'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->c_view),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'c_create',
                        'label' => t('Creating a company'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->c_create),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'c_edit',
                        'label' => t('Editing a company'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->c_edit),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'c_delete',
                        'label' => t('Deleting a company'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->c_delete),
                    ];    
}
if ($model->d_view) {
    $attributes[] = [
                        'group'=>true,
                        'label'=> t('Document management'),
                        'rowOptions'=>['class'=>'table-agro-subhead']
                    ];
    $attributes[] = [                    
                        'attribute' => 'd_view',
                        'label' => t('View documents'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->d_view),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'd_create',
                        'label' => t('Creating a document'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->d_create),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'd_edit',
                        'label' => t('Editing a document'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->d_edit),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'd_delete',
                        'label' => t('Deleting a document'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->d_delete),
                    ];    
}
if ($model->co_view) {
    $attributes[] = [
                        'group'=>true,
                        'label'=> t('Contract management'),
                        'rowOptions'=>['class'=>'table-agro-subhead']
                    ];
    $attributes[] = [                    
                        'attribute' => 'co_view',
                        'label' => t('View contracts'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->co_view),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'co_create',
                        'label' => t('Creating a contract'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->co_create),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'co_edit',
                        'label' => t('Editing a contract'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->co_edit),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'co_delete',
                        'label' => t('Deleting a contract'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->co_delete),
                    ];     
}
if ($model->r_view) {
    $attributes[] = [
                        'group'=>true,
                        'label'=> t('Rubricator management'),
                        'rowOptions'=>['class'=>'table-agro-subhead']
                    ];
    $attributes[] = [                    
                        'attribute' => 'r_view',
                        'label' => t('View the rubricator'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->r_view),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'r_create',
                        'label' => t('Creating a rubricator section'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->r_create),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'r_edit',
                        'label' => t('Editing a rubricator section'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->r_edit),
                    ];    
    $attributes[] = [                    
                        'attribute' => 'r_delete',
                        'label' => t('Deleting a rubricator section'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->r_delete),
                    ];     
}
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
                'mode' => DetailView::MODE_VIEW,
                'model' => $model,
                'attributes' => $attributes,
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

