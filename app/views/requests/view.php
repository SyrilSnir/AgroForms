<?php

use app\core\helpers\View\Request\RequestStatusHelper;
use app\core\manage\Auth\Rbac;
use app\models\ActiveRecord\Logs\ApplicationRejectLog;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Requests\EditRequestForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Request */
/* @var $statusForm EditRequestForm */
/* @var array $logs */
/* @var $requestHtml string */
$this->title = t('Application №','requests') . $model->id;
$attributes = [
    'formType.name:text:' . t('Form type', 'requests'),
    [
        'attribute' => 'contracr',
        'label' => t('Number of contract'),
        'value' => $model->contract ? $model->contract->number : ''
    ],     
    [
        'attribute' => 'company',
        'label' => t('Company','company'),
        'value' => $model->user->company->name
    ],
    [
        'attribute' => 'email',
        'label' => t('Member email','user'),
        'value' => $model->user->email
    ],    
    
    [
        'attribute' => 'status',
        'label' => t('Status'),
        'format' => 'raw',
        'value' => RequestStatusHelper::getStatusLabel($model->status)
    ]    
    
];

?>
<div class="request__view">
    <?php if (Yii::$app->session->hasFlash('success')):?>
    <div class="alert alert-primary" role="alert">
            <?php echo Yii::$app->session->getFlash('success')?>
    </div>
    <?php endif ;?>  
    
    <?php if (Yii::$app->user->can('adminMenu')):?>
    
        <?php echo $this->render('status-block-layouts/admin-layout.php',[
            'statusForm' => $statusForm
        ]) ?>
    
    <?php endif; ?>   
    
    <?php if (Yii::$app->user->can('accountantMenu') ||
            Yii::$app->user->can('organizerMenu')):?>
    
        <?php echo $this->render('status-block-layouts/accountant-layout.php',[
            'statusForm' => $statusForm
        ]) ?>
    
    <?php endif; ?> 
    
    <p>
        <?= Html::a(t('Print to PDF'), Url::current(['print', 'id' => $model->id]), ['class' => 'btn btn-outline-danger']) ?>
        <?= Html::a(t('Back'), Url::previous(), ['class' => 'btn btn-secondary']) ?>
    </p>      
    <?php if (!Yii::$app->user->can(Rbac::PERMISSION_MEMBER_MENU)):?>
    <div class="card">
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
    <?php endif ; ?>
    <?php  echo $requestHtml ?>
    
<?php
 /** @var ApplicationRejectLog $activeMessage */
 /** @var ApplicationRejectLog[] $historyMessages */

$activeMessage = $logs['active'];
$historyMessages = $logs['history'];

?>
<?php if(!empty($activeMessage) || !empty($historyMessages)): ?>
<div class="content organizer__comments">    
    <div class="container-fluid">
        <h2><?php echo t('Information from the organizer') ?></h2>        
            <?php if(!empty($activeMessage)): ?>
        <div class="row">
            <div class="card">
                <div class="card-header"><div class="title__text"><?php echo t('Important information') ?></div><div class="date"><span><?php echo $activeMessage->formatDate ?></span></div></div>
                <div class="card-body"><?php echo $activeMessage->comment ?></div>
            </div>
        </div>  
            <?php endif; ?>
            <?php if(!empty($historyMessages)): ?>        
        <div class="row">
            <h3><?php echo t('Message history') ?></h3>
            
                    <?php foreach ($historyMessages as $message):?>
            <div class="card">
                <div class="date__wrapper"><span class="date"><?php echo $message->formatDate ?></span></div>
                <div class="card-body"><?php echo $message->comment?></div>
            </div>
                    <?php endforeach; ?>
        </div>         
            <?php endif; ?>
    </div>        
</div>    
</div>
<?php endif; ?>

