<?php

use app\core\helpers\Utils\users\RolesHelper;
use app\models\ActiveRecord\Companies\Company;
use app\models\SearchModels\Companies\CompanySearch;
use app\models\Data\Operations;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $searchModel CompanySearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/company','Directory of companies');
$this->params['breadcrumbs'][] = $this->title;
$user = RolesHelper::getUser();
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$toolbarContent = $rowsCountTemplate .
                                Html::a('<i class="fas fa-redo"></i>', [''], [
                                    'class' => 'btn btn-outline-secondary',
                                    'title'=>t('Default sort'),
                                    'data-pjax'=> '', 
                                ]);
if ($user->canOperation(Operations::ENTITY_COMPANY, Operations::OP_CREATE)) {
    $toolbarContent .=  Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-success',
                                    'title' => Yii::t('app/company', 'Add company'),
                                ]);
}
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=>  $toolbarContent                           
                        ]
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [                    
                        'name:text:'. Yii::t('app/company', 'Name'),
                        'full_name:text:'. Yii::t('app/company', 'Full name'),
                        [
                            'label' => Yii::t('app/company', 'Company`s logo'),
                            'value' => function (Company $model) {
                                return Html::img($model->getThumbFileUrl('logo'),['style' => 'width: 80px']);
                            },
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width: 100px'],
                        ],                        
                        [
                            'attribute' => 'blocked',
                            'label' => Yii::t('app','Status'),
                            'format' => 'raw',
                            'filter' => [
                                0 => t('Active','company'),
                                1 => t('Blocked','company')
                            ],
                            'value' =>
                                function (Company $model) {
                                    return $model->isBlocked() ? t('Blocked','company') : t('Active','company');
                                }
                        ],                        
                        [
                            'class' => ActionColumn::class,
                            'hAlign' => GridView::ALIGN_LEFT,
                            'width' => '140px',
                            'template' => '{view}{update}{delete}&nbsp;&nbsp;&nbsp;{block}{member}',                            
                            'buttons' => [
                                'member' => function ($url, $model, $key) {
                                    /** @var Company $model */
                                    $title = t('Create new member','user');
                                    $iconName = "user";
                                    $url = Url::current(['add-member', 'id' => $key]);
                                    $options = [
                                        'title' => $title,
                                        'aria-label' => $title,
                                    ];                                  
                                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                                    return Html::a($icon, $url,$options);                            
                                    
                                },
                                'block' => function ($url, $model, $key) {
                                    /** @var Company $model */
                                    if ($model->isBlocked()) {
                                        $title = Yii::t('app/company','Unblock company');
                                        $iconName = "ok-sign";
                                        $url = Url::current(['unblock', 'id' => $key]);
                                    } 
                                    else {
                                        $title = Yii::t('app/company','Block company');
                                        $iconName = "remove-circle";
                                        $url = Url::current(['block', 'id' => $key]);
                                    }
                                    $options = [
                                        'title' => $title,
                                        'aria-label' => $title,
                                    ];                                  
                                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                                    return Html::a($icon, $url,$options);                                    
                                }
                                ],
                                
                            'visibleButtons' => [
                                'delete' => Yii::$app->user->can('adminMenu'),
                                'block' => $user->canOperation(Operations::ENTITY_COMPANY, Operations::OP_DELETE),
                                'update' => $user->canOperation(Operations::ENTITY_COMPANY, Operations::OP_EDIT),
                                'member' => function ($model) use ($user) {
                                    /** @var Company $model */                                    
                                    return !$model->member && $user->canOperation(Operations::ENTITY_USER, Operations::OP_CREATE);
                                },
                                        
                            ]                            
                        ],
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

