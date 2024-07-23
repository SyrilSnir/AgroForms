<?php

use app\core\helpers\Utils\users\RolesHelper;
use app\core\helpers\View\User\UserStatusHelper;
use app\models\ActiveRecord\Users\User;
use app\models\Data\Operations;
use app\models\SearchModels\Users\UserSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $searchModel UserSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/user', 'Users management');
$this->params['breadcrumbs'][] = $this->title;
$user = RolesHelper::getUser();
$adminList = Yii::$app->params['rootUsers'] ?? [];
$action = Yii::$app->getRequest()->getPathInfo();
?>
<section class="content content-large">
    <div class="card">
<?php 

    $rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
    $toolbarContent = $rowsCountTemplate;
    if ($user->canOperation(Operations::ENTITY_USER, Operations::OP_CREATE)) {
        $toolbarContent .=  Html::a('<i class="fas fa-plus"></i>',['create-member'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app/user', 'Create new member'),
                                ]);
    }
// Добавление нового пользователя из панели администратора не имеет смысла
    $columnsConfig = [                    
                    'toolbar' => [
                        [
                            'content'=> $toolbarContent
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
                            'attribute' => 'active',
                            'label' => Yii::t('app/user','Status'),
                            'width' => '100px',
                            'format' => 'raw',                           
                            'filterType' => GridView::FILTER_SELECT2,                            
                            'filter' => UserStatusHelper::statusList(),
                            'filterWidgetOptions' => [
                                'options' => ['placeholder' => ''],
                            ],                            
                            'value' => function (User $model) {
                                return UserStatusHelper::getStatusLabel($model->active);
                            }
                        ],                         
                        [ 
                            'class' => ActionColumn::class,
                            'width' => '100px',                            
                             'visibleButtons' => [
                                'update' => $user->canOperation(Operations::ENTITY_USER, Operations::OP_EDIT),
                                'delete' => $user->canOperation(Operations::ENTITY_USER, Operations::OP_DELETE)
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
