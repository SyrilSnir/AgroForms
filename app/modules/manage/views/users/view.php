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
/* @var $model User */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->login;

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
                        'value' => UserStatusHelper::getStatusLabel($model->active)
                    ]
                ];
switch ($model->user_type_id) {
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
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить пользователя?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Вернуться', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $this->title ?></h3>
                </div>
                    <div class="card-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => $attributes,
                        ]); ?>
                    </div>
            </div>
        </div>
        <?php if (!$model->active) :?>  

        <div class="col-md-6">  
        <?php 
            $activateFornModel = new ActivateForm($model->email);
            $activateForm = ActiveForm::begin([
                'action' => Url::to(['/manage/users/invite', 'id' => $model->id ])
            ]);
        ?>            
            <div class="card card-secondary">
                    <div class="card-header">
                      <h3 class="card-title">Активировать пользователя</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                          <i class="fas fa-minus"></i></button>
                      </div>
                    </div>
                    <div class="card-body" style="display: block;">
    <?= $activateForm->field($activateFornModel, 'email')
                ->textInput()
                ?>
                    </div>
                    <!-- /.card-body -->
                  </div>
         <div class="form-group">
            <?= Html::submitButton('Отправить приглашение на e-mail', [
                'class' => 'btn btn-primary mb-3' ]) ?>
            <?= Html::tag('div','Получить ссылку для активации пользователя', 
                    [
                        'id' => 'get-activare-link',
                        'class' => 'btn btn-primary', 
                        'data-user' => $model->id
                    ]) ?>
        </div>
        <?php ActiveForm::end(); ?>               
        <?php endif ;?>           
            </div> 


    </div>
</div>
<div id="show-activate-link" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">По данной ссылке можно активировать пользователя</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <a id="activate-link" href=""></a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

