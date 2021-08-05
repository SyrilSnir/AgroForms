<?php

use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\SearchModels\Forms\FieldSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use kartik\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Form */
/* @var $formFieldsDataProvider ActiveDataProvider */
/* @var $formFieldsModel FieldSearch */

$this->title = $model->name;
?>
<div class="category-view">
    <p>
        <?= Html::a(Yii::t('app', 'Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($model->form_type_id !== FormType::SPECIAL_STAND_FORM):?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete the form?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title:text:' . Yii::t('app', 'Title'),
                    'name:text:' . Yii::t('app', 'Name'),
                    'description:raw:' . Yii::t('app', 'Description'),
                    'formType.name:text:' . Yii::t('app/requests', 'Form type'),
                    'order:text:' . Yii::t('app', 'Serial number'),
                    'valute.name:text:' . Yii::t('app', 'Valute'),
                    
                ],
            ]); ?>
    </div>
</div>
<?php if (in_array($model->form_type_id, FormType::HAS_DYNAMIC_FIELDS)): ?>
<?php 
$columnsConfig = [
                    'toolbar' => [
                        [
                            'header' => 'rrrgrg',
                            'content'=> //$rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['fields/create', 'formId' => $model->id], [
                                    'class' => 'btn btn-sm btn-success',
                                ])                            
                        ],
                    ],
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => Yii::t('app','List of fields')
                    ],
                    'dataProvider' => $formFieldsDataProvider,
                    'filterModel' => $formFieldsModel,
                    'columns' => [  
                        'order:text:' . Yii::t('app','Position'),
                        'name:text:' . Yii::t('app','Name'),
                        [
                            'label' => Yii::t('app','Group'),
                            'filter' => $formFieldsModel->fieldGroupList(),
                            'attribute' => 'fieldGroupId',
                            'value' => function (Field $model) {
                                return $model->fieldGroup ? $model->fieldGroup->name:
                                        Yii::t('app','Undefined');
                            }
                        ],
                        'description:text:' . Yii::t('app','Description'),
                        
                        [
                            'label' => Yii::t('app','Element type'),
                            'attribute' => 'elementTypeId',
                            'filter' => $formFieldsModel->elementTypesList(),
                            'value' => function (Field $model) {
                                    return $model->elementType->name;
                                }
                            ],
                        [
                            'class' => ActionColumn::class,
                           // 'header' => 'Действия',
                            'controller' => 'fields'                       
                        ],
                    ],    
    ];
$gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';    
$fullGridConfig = array_merge($gridConfig, $columnsConfig);
?>
    <div class="card">
        <div class="card-body">
            <?= GridView::widget($fullGridConfig); ?>
        </div>
    </div>  
<?php endif; ?>

