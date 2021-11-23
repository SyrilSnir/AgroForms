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
                    'login:text:' . t('Login','user'),
                    'fio:text:' . t('Full name','user'),
                    'email:text:' . t('Email','user'),
                    'phone:text:' . t('Phone number','user'),
                    'company.name:text:' . t('Company','user'),
                    'userType.name:text:' . t('User type', 'user'),
                    [
                        'attribute' => 'active',
                        'label' => t('Status'),
                        'format' => 'raw',
                        'value' => UserStatusHelper::getStatusLabel($model->active)
                    ]
                ];
/*
switch ($model->user_type_id) {
    case UserType::MEMBER_USER_ID:
        $dopAttributes = [
            'profile.position:text:' . t('Position', 'user'),
            'profile.activities:text:' . t('Scope of the company','company'),
            'profile.proposal_signature_name:text:' . t('Signer\'s full name','company'),
            'profile.proposal_signature_post:text:' . t('Signer\'s position','company'),
        ];
        $attributes = ArrayHelper::merge($attributes, $dopAttributes);
        break;
}
 * 
 */
?>
<div class="full-view">
    <p>
        <?= Html::a(t('Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(t('Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => t('Are you sure you want to delete the user?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(t('Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
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
                        <h3 class="card-title"><?php t('Activate user','user')?></h3>

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
            <?= Html::submitButton(t('Send invitation by e-mail','user'), [
                'class' => 'btn btn-primary mb-3' ]) ?>
            <?= Html::tag('div',t('Get a link to activate a user','user'), 
                    [
                        'id' => 'get-activare-link',
                        'class' => 'btn btn-primary mb-3',  
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
          <h5 class="modal-title"><?php echo t('By this link you can activate the user','user') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <a id="activate-link" href=""></a>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo t('Close') ?></button>
      </div>
    </div>
  </div>
</div>

