<?php

use app\models\SearchModels\Users\UserSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $searchModel UserSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/user', 'Deleted users');
$this->params['breadcrumbs'][] = $this->title;
$adminList = Yii::$app->params['rootUsers'] ?? [];
$action = Yii::$app->getRequest()->getPathInfo();
?>
<section class="content content-large">
    <div class="card">
<?php 

// Добавление нового пользователя из панели администратора не имеет смысла
    $rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
    $columnsConfig = [                    
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-eye"></i>', ['/panel/users'], [
                                    'class' => 'btn btn-outline-secondary',
                                    'title'=>t('All users'),
                                ]).   
                                Html::a('<i class="fas fa-redo"></i>', [''], [
                                    'class' => 'btn btn-outline-secondary',
                                    'title'=>t('Default sort'),
                                    'data-pjax'=> '', 
                                ])
                        ],
                    ],                   
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [ 
                        [
                            'attribute' => 'login',
                            'label' => Yii::t('app/user','Login'),
                            'width' => '110px'
                        ],
                        'email:text:'.Yii::t('app/user','E-mail'),
                        'fio:text:'.Yii::t('app/user','Full name'),
                        [
                            'attribute' => 'company_id',
                            'value' => 'company.name',
                            'label' => Yii::t('app/user','Company'),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => $searchModel->companiesList(),
                            'width' => '200px',
                            'filterWidgetOptions' => [
                                'options' => ['placeholder' => ''],
                            ]
                        ],
                        [
                            'attribute' => 'user_type_id',
                            'label' => Yii::t('app/user','User type'),
                            'filter' => $searchModel->userTypeList(),
                            'value' => 'userType.name'
                        ],                       
                        [ 
                            'class' => ActionColumn::class,
                            'template' => '{view} {update} {restore}',
                            'width' => '100px',   
                            'buttons' => [
                                'restore' => function ($url, $model, $key) {
                                    $title = t('Restore user','requests');
                                    $iconName = "ok-circle";
                                    $url = Url::current(['restore', 'id' => $key]);
                                    $options = [
                                        'title' => $title,
                                        'aria-label' => $title,
                                    ];                                  
                                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                                    return Html::a($icon, $url,$options);        
                                }
                            ]
                        ],
                    ],
                ];
        $gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';
        $fullGridConfig = array_merge($columnsConfig,$gridConfig);
 ?>
        <div class="card-body">
          <?php Pjax::begin(); ?>
                <?= GridView::widget($fullGridConfig); ?>
          <?php Pjax::end(); ?>
        </div>
    </div>
</section>