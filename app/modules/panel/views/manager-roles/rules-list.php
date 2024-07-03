<?php

use app\core\helpers\View\YesNoStatusHelper;
use app\models\ActiveRecord\Users\ManagerRoleRules;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var yii\data\ActiveDataProvide $provider */
/** @var ManagerRoleRules $model */
$columnsConfig = [ 
    'toolbar' => [
        [
            'content' => $this->render('_form-select') . 
                Html::a('<i class="fas fa-plus"></i>',['manager-role-rules/create'], [
                            'class' => 'btn btn-sm btn-success',
                            'id' => 'create-new-rule',
                            'data-role' => $roleId,
                            'title' => Yii::t('app/title', 'New rule'),
                        ])  
        ],
    ],                    
    'dataProvider' => $provider,
    'filterModel' => $searchModel,
    'columns' => [                    
        [
            'attribute' => 'title',
            'label' => 'Форма',
            'value' => function (ManagerRoleRules $model) {
                return $model->form->title . ':' . $model->form->name;
            }
        ],
        'form.exhibition.title:text:Выставка',
        [
            'attribute' => 'view',
            'label' => 'Просмотр',
            'format' => 'raw',
            'filter' => YesNoStatusHelper::statusList(),
            'value' => function (ManagerRoleRules $model) {
                return YesNoStatusHelper::getStatusLabel($model->r_view);
            }                            
        ],
        [
            'attribute' => 'accept',
            'label' => 'Принимать заявки',
            'format' => 'raw',
            'filter' => YesNoStatusHelper::statusList(),
            'value' => function (ManagerRoleRules $model) {
                return YesNoStatusHelper::getStatusLabel($model->r_accept);
            }                            
        ],
        [
            'attribute' => 'pay',
            'label' => 'Оплата',
            'format' => 'raw',
            'filter' => YesNoStatusHelper::statusList(),
            'value' => function (ManagerRoleRules $model) {
                return YesNoStatusHelper::getStatusLabel($model->r_pay);
            }                            
        ],
        [
            'attribute' => 'view',
            'label' => 'Публикация',
            'format' => 'raw',
            'filter' => YesNoStatusHelper::statusList(),
            'value' => function (ManagerRoleRules $model) {
                return YesNoStatusHelper::getStatusLabel($model->r_publicate);
            }                            
        ],
        [
            'attribute' => 'view',
            'label' => 'Удаление',
            'format' => 'raw',
            'filter' => YesNoStatusHelper::statusList(),
            'value' => function (ManagerRoleRules $model) {
                return YesNoStatusHelper::getStatusLabel($model->r_delete);
            }                            
        ],
        [
            'class' => ActionColumn::class,
            'controller' => 'manager-role-rules',                       
        ],
    ],    
];
$gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';
$fullGridConfig = array_merge($columnsConfig,$gridConfig);
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Правила для заявок</h3>
    </div>
    <div class="card-body">
        <?= GridView::widget($fullGridConfig); ?>
    </div>
</div> 
