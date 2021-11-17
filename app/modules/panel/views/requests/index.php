<?php

use app\core\helpers\Data\FormsHelper;
use app\core\helpers\View\Request\RequestStatusHelper;
use app\core\manage\Auth\Rbac;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\ActiveRecord\Requests\Request;
use app\models\SearchModels\Requests\RequestStandSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
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
                        'hAlign' => GridView::ALIGN_LEFT,
                        'template' => '{view}{update}{change_status}{delete}&nbsp;&nbsp;&nbsp;{invoice}{inform}{accept}&nbsp;{reject}', 
                        'buttons' => [
                            'accept' => function ($url, $model, $key) {
                                    /** @var Request $model */
                                $title = t('Accept application','requests');
                                $iconName = "thumbs-up";
                                $url = Url::current(['accept', 'id' => $key]);
                                $options = [
                                    'title' => $title,
                                    'aria-label' => $title,
                                ];                                  
                                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                                return Html::a($icon, $url,$options);                            
                            },
                              'reject' => function ($url, $model, $key) {
                                    /** @var Request $model */
                                $title = t('Reject application','requests');
                                $iconName = "thumbs-down";
                                $url = Url::current(['reject', 'id' => $key]);
                                $options = [
                                    'title' => $title,
                                    'aria-label' => $title,
                                ];                                  
                                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                                return Html::a($icon, $url,$options);                            
                            },   
                            'invoice' => function ($url, $model, $key) {
                                    /** @var Request $model */
                                $title = t('Invoice','requests');
                                $iconName = "usd";
                                $url = Url::current(['invoice', 'id' => $key]);
                                $options = [
                                    'title' => $title,
                                    'aria-label' => $title,
                                ];                                  
                                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                                return Html::a($icon, $url,$options);                            
                            },  
                            'change_status' => function ($url, $model, $key) {
                                    /** @var Request $model */
                                $title = t('Change status','requests');
                                $iconName = "pencil";
                                $url = Url::current(['change-status', 'id' => $key]);
                                $options = [
                                    'title' => $title,
                                    'aria-label' => $title,
                                ];                                  
                                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                                return Html::a($icon, $url,$options);                            
                            },
                        ],
                        'visibleButtons' => [
                            'change_status' => Yii::$app->user->can(Rbac::PERMISSION_ADMINISTRATOR_MENU),
                            'inform' => function ($model) {
                                /** @var Request $model */
                                return true;
                                return Yii::$app->user->can(Rbac::PERMISSION_MEMBER_MENU) &&
                                        $model->status === BaseRequest::STATUS_REJECTED;
                            },
                            'invoice' => function($model) {
                                /** @var Request $model */
                                return Yii::$app->user->can(Rbac::PERMISSION_MANAGER_MENU) &&
                                        $model->status === BaseRequest::STATUS_ACCEPTED;
                            },
                            'accept' => function ($model) {
                                /** @var Request $model */
                                return ($model->status === BaseRequest::STATUS_NEW || 
                                        $model->status === BaseRequest::STATUS_CHANGED) &&
                                        !Yii::$app->user->can(Rbac::PERMISSION_MANAGER_MENU);
                            },   
                            'reject' => function ($model) {
                                /** @var Request $model */
                                return ($model->status === BaseRequest::STATUS_NEW || 
                                        $model->status === BaseRequest::STATUS_CHANGED) &&
                                        !Yii::$app->user->can(Rbac::PERMISSION_MANAGER_MENU);
                            },                                     
                            'update' => function ($model) {
                                /** @var Request $model */
                                return ($model->status === BaseRequest::STATUS_DRAFT);
                            },
                            'delete' => function ($model) {
                                /** @var Request $model */
                                return !Yii::$app->user->can(Rbac::PERMISSION_ACCOUNTANT_MENU) &&
                                        !Yii::$app->user->can(Rbac::PERMISSION_ORGANIZER_MENU) &&
                                        !Yii::$app->user->can(Rbac::PERMISSION_MANAGER_MENU);
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

