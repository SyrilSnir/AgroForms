<?php

use app\models\ActiveRecord\Forms\Field;
use app\models\SearchModels\Forms\FieldSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel FieldSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title', 'Directory of fields');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app', 'Add field'),
                                ])                            
                        ],
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [                    
                        'order:integer:' . Yii::t('app', 'Serial number'),
                        [
                            'filter' => $searchModel->formsList(),
                            'attribute' => 'formId',
                            'label' => Yii::t('app', 'Form'),
                            'value' => function (Field $model) {
                                return $model->form->name;
                            }                         
                        ],
                        'name:text:' . Yii::t('app', 'Name'),
                        [
                            'attribute' => 'fieldGroupId',
                            'label' => Yii::t('app', 'Group'),
                            'filter' => $searchModel->fieldGroupList(),
                            'value' => function (Field $model) {
                                return $model->fieldGroup ? $model->fieldGroup->name: Yii::t('app', 'Undefined');
                            }
                        ],
                        ['class' => ActionColumn::class],
                    ],    
    ];
$gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';
$fullGridConfig = array_merge($columnsConfig,$gridConfig);                        
?>
<section class="content">
    <div class="card">
        <div class="card-body">
                <?= GridView::widget($fullGridConfig); ?>
        </div>
    </div>
</section>

