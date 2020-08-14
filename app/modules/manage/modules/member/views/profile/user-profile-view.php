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
                    'login:text:'.Yii::t('app/user','Login'),
                    'fio:text:'.Yii::t('app/user','Full name'),
                    'email:text:E-mail',
                    'phone:text:' . Yii::t('app/user', 'Phone'),
                    'company.name:text:'. Yii::t('app/user', 'Company'),
                    [
                        'label' => Yii::t('app/user', 'Position'),
                        'value' => $profile->position ? $profile->position : '(' . mb_convert_case(t('Undefined'), MB_CASE_LOWER) . ')'
                    ],
                    [
                        'attribute' => 'active',
                        'label' => Yii::t('app/user', 'Status'),
                        'format' => 'raw',
                        'value' => UserStatusHelper::getStatusLabel($profile->active)
                    ]
                ];
?>
<div class="full-view">
        <p>
        <?= Html::a(Yii::t('app','Change'), ['update-user'], ['class' => 'btn btn-primary']) ?>
    </p>
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



