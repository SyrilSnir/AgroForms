<?php

use app\core\helpers\Data\FormsHelper;
use app\core\helpers\View\Request\RequestStatusHelper;
use app\core\manage\Auth\Rbac;
use app\models\ActiveRecord\Requests\BaseRequest;
use app\models\ActiveRecord\Requests\Request;
use app\models\SearchModels\Requests\RequestSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel RequestSearch */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = Yii::t('app/title', 'Requests list');
$action = Yii::$app->getRequest()->getPathInfo();
$actionId = Yii::$app->controller->action->id;

$isAcceptDeclineShowed = ($actionId === 'new');
$isPayShowed = (Yii::$app->user->can(Rbac::PERMISSION_ORGANIZER_MENU) ||
    Yii::$app->user->can(Rbac::PERMISSION_ACCOUNTANT_MENU));

$isDeleteShowed = (!Yii::$app->user->can(Rbac::PERMISSION_ACCOUNTANT_MENU) &&
                                        !Yii::$app->user->can(Rbac::PERMISSION_ORGANIZER_MENU) &&
                                        !Yii::$app->user->can(Rbac::PERMISSION_MANAGER_MENU));

$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';
$columnsConfig = [
                'toolbar' => [
                    [
                        'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-file-excel"></i>', ['excel'], [
                                    'class' => 'btn btn-outline-secondary',
                                    'title'=>t('Export to Excel'),
                                    'data-pjax'=> '', 
                                ])
                    ],
                ],      
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel, 
                'columns' => [
                    [
                        'label' => Yii::t('app/company','Company'),
                        'value' => 'user.company.name',
                        'attribute' => 'company',
                        'format' => 'text',
                        'filter' => $searchModel->companiesList(),
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterWidgetOptions' => [
                            'options' => ['prompt' => ''],
                            'pluginOptions' => ['allowClear' => true],
                        ],                        
                    ],
                    [
                      'attribute' => 'form_id',
                      'label' => Yii::t('app','Form'),
                      'filter' => FormsHelper::formsList(),                        
                      'value' => 'header'
                    ],
                  // 'header:text:' . Yii::t('app','Form'),
                    [
                        'attribute' => 'status',
                        'width' => '160px',
                        'label' => Yii::t('app','Status'),
                        'format' => 'raw',
                        'filter' => RequestStatusHelper::statusList(false),
                        'value' => function (Request $model) {
                            return RequestStatusHelper::getStatusLabel($model->status);
                        }
                    ],
                    [
                    'attribute' => 'price',
                      'label' => Yii::t('app','Price'),
                      'value' => function (Request $model) {
                        return $model->requestForm->amount . ' ' .$model->form->valute->symbol;
                      }
                      ],
                    'created_at:datetime:' . Yii::t('app','Created at'),
                    'activate_at:datetime:' . Yii::t('app','Sended at'),

                    [
                        'class' => ActionColumn::class,
                        'hAlign' => GridView::ALIGN_LEFT,
                        'width' => '260px',
                        'template' => '<span class="action__wrapper">{view}</span>' .
(Yii::$app->user->can(Rbac::PERMISSION_ADMINISTRATOR_MENU) ? '<span class="action__wrapper">{change}</span>' : '').
                        
($isDeleteShowed ?                     '<span class="action__wrapper">{delete}</span>' : '').
                        
($isPayShowed ?                        '<span class="action__wrapper">{partial_paid}</span>
                                       <span class="action__wrapper">{paid}</span>' : '').
                        
($isAcceptDeclineShowed ?               '<span class="action__wrapper">{accept}</span>
                                       <span class="action__wrapper">{reject}</span>' : '') .
                        
                                       '<span class="action__wrapper">{pdf}</span>',
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
                              'pdf' => function ($url, $model, $key) {
                                    /** @var Request $model */
                                $title = t('Open for print');
                                $iconName = "print";
                                $url = Url::current(['print', 'id' => $key]);
                                $options = [
                                    'title' => $title,
                                    'aria-label' => $title,
                              //      'data-toggle' => 'modal',
                             //       'data-target' => '#modal__information',                                   
                                ];                                  
                                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                                return Html::a($icon, $url,$options);                            
                            },                                      
                            'partial_paid' => function ($url, $model, $key) {
                                    /** @var Request $model */
                                $title = t('Partial paid','requests');
                                $iconName = "icon-ppay";
                                $url = Url::current(['partial-pay', 'id' => $key]);
                                $options = [
                                    'title' => $title,
                                    'aria-label' => $title,
                                ];                                  
                                $icon = Html::tag('span', '', ['class' => "fa $iconName"]);
                                return Html::a($icon, $url,$options);                            
                            },                                     
                            'paid' => function ($url, $model, $key) {
                                    /** @var Request $model */
                                $title = t('Application paid','requests');
                                $iconName = "icon-pay";
                                $url = Url::current(['pay', 'id' => $key]);
                                $options = [
                                    'title' => $title,
                                    'aria-label' => $title,
                                ];                                  
                                $icon = Html::tag('span', '', ['class' => "fa $iconName"]);
                                return Html::a($icon, $url,$options);                            
                            },  
                            'change' => function ($url, $model, $key) {
                                    /** @var Request $model */
                                $title = t('Edit');
                                $iconName = "pencil";
                                $url = Url::current(['edit', 'id' => $key]);
                                $options = [
                                    'title' => $title,
                                    'aria-label' => $title,
                                ];                                  
                                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                                return Html::a($icon, $url,$options);                            
                            },
                        ],
                        'visibleButtons' => [
                            'change' => Yii::$app->user->can(Rbac::PERMISSION_ADMINISTRATOR_MENU),
                            'paid' => function($model) {
                                /** @var Request $model */
                                return (Yii::$app->user->can(Rbac::PERMISSION_ORGANIZER_MENU) ||
                                        Yii::$app->user->can(Rbac::PERMISSION_ACCOUNTANT_MENU)) &&
                                        ($model->status === BaseRequest::STATUS_INVOICED ||
                                        $model->status === BaseRequest::STATUS_PARTIAL_PAID);
                            },
                            'partial_paid' => function($model) {
                                /** @var Request $model */
                                return (Yii::$app->user->can(Rbac::PERMISSION_ORGANIZER_MENU) ||
                                        Yii::$app->user->can(Rbac::PERMISSION_ACCOUNTANT_MENU)) &&
                                        $model->status === BaseRequest::STATUS_INVOICED;
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
                            'update' => false,
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

<?php
 Modal::begin([
     'title' => '<h3>' . t('Will be soon') .'...</h3>',
     'options' => [
         'id' => 'modal__information'
     ],
 ]);
Modal::end();