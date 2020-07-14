<?php

use app\core\helpers\View\User\UserStatusHelper;
use app\models\ActiveRecord\Users\User;
use app\models\SearchModels\User\UserSearch;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel UserSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Управление пользователями';
$this->params['breadcrumbs'][] = $this->title;
$adminList = Yii::$app->params['rootUsers'] ?? [];
?>
<section class="content">
    <div class="card">
<?php 

// Добавление нового пользователя из панели администратора не имеет смысла
 ?>
    <p>
        <?= Html::a('Добавить участника', ['create-member'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Добавить администратора', ['create-admin'], ['class' => 'btn btn-success']) ?>
    </p>
        <div class="card-header">
          <h3 class="card-title">Управление учетными записями</h3>
        </div>
        <div class="card-body">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [                    
                        'id:integer:Id',
                        'login:text:Логин',
                        'email:text:E-mail',
                        'fio:text:ФИО',
                        'company.name:text:Компания',
                        [
                            'attribute' => 'userTypeId',
                            'label' => 'Тип учетной записи',
                            'filter' => $searchModel->userTypeList(),
                            'value' => 'userType.name'
                        ],
                        [
                            'attribute' => 'moderate',
                            'label' => 'Статус',
                            'format' => 'raw',
                        //    'filter' => $searchModel->statusList(),
                            'value' => function (User $model) {
                                return UserStatusHelper::getStatusLabel($model->active);
                            }
                        ],                        
                        [ 
                            'class' => ActionColumn::class,
                             'visibleButtons' => [
                                'update' => function ($model)  use ($adminList) {
                                    return !in_array($model->login, $adminList );
                                },
                                'delete' => function ($model)  use ($adminList) {
                                    return !in_array($model->login, $adminList );
                                }
                            ]                    
                        ],
                    ],
                ]); ?>
        </div>
    </div>
</section>
