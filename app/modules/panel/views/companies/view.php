<?php

use app\models\ActiveRecord\Companies\Company;
use kartik\detail\DetailView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $model Company */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = Yii::t('app/title','Company info') . ': ' . $model->name;
?>
<div class="category-view">
    <p>
        <?= Html::a(Yii::t('app','Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/user','Create new member'), ['add-member', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'mode'=>DetailView::MODE_VIEW,               
                'model' => $model,
                'attributes' => [
                    [
                        'group'=>true,
                        'label'=> Yii::t('app/company','About company'),
                        'rowOptions'=>['class'=>'table-info']
                    ],
                    'name:text:' . Yii::t('app/company','Name'),
                    'full_name:text:' . Yii::t('app/company','Full name'),
                    'inn:text:' . Yii::t('app/company','INN'),
                    'kpp:text:' . Yii::t('app/company','KPP'),
                    'phone:text:' . Yii::t('app/company','Phone'),
                    'fax:text:' . Yii::t('app/company','Fax'),
                    'site:text:' . Yii::t('app/company','Site'),
                    [
                        'group'=> true,
                        'label'=> Yii::t('app/company','Address'),
                        'rowOptions'=>['class'=>'table-info']
                    ],
                    [
                        'group'=> true,
                        'label'=> Yii::t('app/company','Legal address'),
                        'rowOptions'=>['class'=>'table-success']
                    ],
                    [
                        'value' => $model->legalAddress->index,
                        'label' => Yii::t('app/company','Zip code')
                    ],                  
                    [
                        'value' => $model->legalAddress->address,
                        'label' => Yii::t('app/company','Address')
                    ],
                    [
                        'value' => $model->legalAddress->city->name,
                        'label' => Yii::t('app','City')                        
                    ],
                    [
                        'group'=>true,
                        'label'=> Yii::t('app/company','Mailing address'),
                        'rowOptions'=>['class'=>'table-success']
                    ],
                    [
                        'value' => $model->postalAddress->index,
                        'label' => Yii::t('app/company','Zip code')
                    ],                  
                    [
                        'value' => $model->postalAddress->address,
                        'label' => Yii::t('app/company','Address')
                    ],
                    [
                        'value' => $model->postalAddress->city->name,
                        'label' => Yii::t('app','City')  
                    ],
                    [
                        'group'=> true,
                        'label'=> Yii::t('app/company','Contacts'),
                        'rowOptions'=>['class'=>'table-info']
                    ],
                    [
                        'group'=> true,
                        'label'=> Yii::t('app/company','Head of company'),
                        'rowOptions'=>['class'=>'table-success']
                    ], 
                    [
                        'value' => $model->contacts->chief_position,
                        'label' => Yii::t('app/company','Head position')
                    ],                    
                    [
                        'value' => $model->contacts->chief_fio,
                        'label' => Yii::t('app/company','Head full name')
                    ],
                    [
                        'value' => $model->contacts->chief_phone,
                        'label' => Yii::t('app/company','Head phone')
                    ],                    
                    [
                        'value' => $model->contacts->chief_email,
                        'label' => Yii::t('app/company','Head email')
                    ], 
                    [
                        'group'=> true,
                        'label'=> Yii::t('app/company','Project manager'),
                        'rowOptions'=>['class'=>'table-success']
                    ], 
                    [
                        'value' => $model->contacts->manager_position,
                        'label' => Yii::t('app/company','Manager\'s position'),
                    ],                    
                    [
                        'value' => $model->contacts->manager_fio,
                        'label' => Yii::t('app/company','Manager\'s full name'),
                    ],
                    [
                        'value' => $model->contacts->manager_phone,
                        'label' => Yii::t('app/company','Manager\'s phone'),
                    ],
                    [
                        'value' => $model->contacts->manager_fax,
                        'label' => Yii::t('app/company','Manager\'s fax'),
                    ],                    
                    [
                        'value' => $model->contacts->manager_email,
                        'label' => Yii::t('app/company','Manager\'s email'),
                    ], 
                    [
                        'group'=> true,
                        'label'=> Yii::t('app/company','Signer (used in proposal)'),
                        'rowOptions'=>['class'=>'table-success']
                    ], 
                    [
                        'value' => $profile->contacts->proposal_signature_name,
                        'label' => Yii::t('app/company','Signer\'s full name'),
                    ],                    
                    [
                        'value' => $profile->contacts->proposal_signature_post,
                        'label' => Yii::t('app/company','Signer\'s position'),
                    ],                    
                    [
                        'group'=> true,
                        'label'=> Yii::t('app/company','Bank details'),
                        'rowOptions'=>['class'=>'table-info']
                    ],
                    [
                        'value' => $model->bankDetails->rs_schet,
                        'label' => Yii::t('app/company','Checking account'),
                    ],
                    [
                        'value' => $model->bankDetails->ks_schet,
                        'label' => Yii::t('app/company','Correspondent account'),
                    ],
                    [
                        'value' => $model->bankDetails->bik,
                        'label' => Yii::t('app/company','BIC'),
                    ],
                    [
                        'value' => $model->bankDetails->bank_info,
                        'label' => Yii::t('app/company','Bank information'),
                    ],                    
                ],
            ]); ?>
        </div>
</div>

