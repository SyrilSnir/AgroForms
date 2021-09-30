<?php

use app\core\helpers\Data\FormsHelper;
use app\core\helpers\View\Request\RequestStatusHelper;
use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\ActiveRecord\Requests\Request;
use app\models\SearchModels\Requests\RequestStandSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel RequestStandSearch */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = Yii::t('app/title', 'Requests list');
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';
$columnsConfig = [
                'toolbar' => [
                    [
                        'content'=> $rowsCountTemplate                           
                    ],
                ],      
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel, 
                'columns' => [
                    'user.company.name:text:' . Yii::t('app','Customer'),
                    [
                      'attribute' => 'formId',
                      'label' => Yii::t('app','Form'),
                      'filter' => FormsHelper::formsList(),                        
                      'value' => 'header'
                    ],
                  // 'header:text:' . Yii::t('app','Form'),
                    [
                        'attribute' => 'status',
                        'label' => Yii::t('app','Status'),
                        'format' => 'raw',
                        'filter' => RequestStatusHelper::statusList(false),
                        'value' => function (Request $model) {
                            return RequestStatusHelper::getStatusLabel($model->status);
                        }
                    ],
                    'created_at:datetime:' . Yii::t('app','Created at'),

                    [
                        'class' => ActionColumn::class,
                        'visibleButtons' => [
                            'update' => function ($model) {
                                /** @var Request $model */
                                return ($model->status === BaseRequest::STATUS_DRAFT);
                            },
                            'delete' => function ($model) {
                                /** @var Request $model */
                                return !Yii::$app->user->can('accountantMenu');
                            }
                        ]                        
                    ],
                ],    
    ];
$fullGridConfig = array_merge($columnsConfig,$gridConfig);                       

?>

<div class="card full-view">
  <div class="card-header">
        <div class="card-body">
 <?php if (Yii::$app->session->has('success')): ?>
    <div class="alert alert-primary" role="alert">
        <?php echo Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->has('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>            
 <?= GridView::widget($fullGridConfig); ?>
        </div>
</div>

