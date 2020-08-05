<?php

use app\core\helpers\View\User\UserStatusHelper;
use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use app\models\Forms\User\Manage\ActivateForm;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $profile User */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $profile->login;

$attributes = [
                    'id',
                    'login:text:Логин',
                    'fio:text:ФИО',
                    'email:text:E-mail',
                    'phone:text:Номер телефона',
                    'company.name:text:Компания',
                    'userType.name:text:Тип учетной записи',
                    [
                        'attribute' => 'active',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => UserStatusHelper::getStatusLabel($profile->active)
                    ]
                ];
switch ($profile->user_type_id) {
    case UserType::MEMBER_USER_ID:
        $dopAttributes = [
            'profile.position:text:Должность',
            'profile.activities:text:Сфера деятельности компании',
            'profile.proposal_signature_name:text:ФИО подписанта',
            'profile.proposal_signature_post:text:Должность подписанта',
        ];
        $attributes = ArrayHelper::merge($attributes, $dopAttributes);
        break;
}
?>
<div class="full-view">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $this->title ?></h3>
                </div>
                    <div class="card-body">
                        <?= DetailView::widget([
                            'model' => $profile,
                            'attributes' => $attributes,
                        ]); ?>
                    </div>
            </div>
        </div>          
            </div> 


    </div>



