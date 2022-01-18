<?php

use app\models\ActiveRecord\Companies\Company;
use kartik\detail\DetailView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $profile Company */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = Yii::t('app/title','Company info') .': ' . $profile->name;
?>
<div class="category-view full-view">
    <p>
    <?= Html::a(t('Change'), ['update-company'], ['class' => 'btn btn-primary']) ?>
    </p>    
<div class="card">
  <div class="card-header">
        <div class="card-body">
            <?= DetailView::widget([
                'mode'=>DetailView::MODE_VIEW,               
                'model' => $profile,
                'attributes' => [
                    [
                        'group'=>true,
                        'label'=> Yii::t('app/company', 'About company'),
                        'rowOptions'=>['class'=>'table-agro-head']
                    ],
                    'name:text:'.Yii::t('app/company','Name'),
                    'full_name:text:' . Yii::t('app/company','Full name'),
                    'inn:text:' . t('INN','company'),
                    'kpp:text:' . t('KPP','company'),
                    'phone:text:' . t('Phone','company'),
                    'fax:text:' . t('Fax','company'),
                    'site:text:' . t('Site','company'),
                    [
                        'group'=>true,
                        'label'=> t('Address','company'),
                        'rowOptions'=>['class'=>'table-agro-head']
                    ],
                    [
                        'group'=>true,
                        'label'=> t('Legal address','company'),
                        'rowOptions'=>['class'=>'table-agro-subhead']
                    ],
                    [
                        'value' => $profile->legalAddress->index,
                        'label' => t('Zip code','company')
                    ],                  
                    [
                        'value' => $profile->legalAddress->address,
                        'label' => t('Address','company')
                    ],
                    [
                        'value' => $profile->legalAddress->city->name,
                        'label' => t('City')                        
                    ],
                    [
                        'group'=>true,
                        'label'=> t('Mailing address','company'),
                        'rowOptions'=>['class'=>'table-agro-subhead']
                    ],
                    [
                        'value' => $profile->postalAddress->index,
                        'label' => t('Zip code','company')
                    ],                  
                    [
                        'value' => $profile->postalAddress->address,
                        'label' => t('Address','company')
                    ],
                    [
                        'value' => $profile->postalAddress->city->name,
                        'label' => t('City')                        
                    ],
                    [
                        'group'=>true,
                        'label'=> t('Contacts','company'),
                        'rowOptions'=>['class'=>'table-agro-head']
                    ],
                    [
                        'group'=>true,
                        'label'=> t('Head of company','company'),
                        'rowOptions'=>['class'=>'table-agro-subhead']
                    ], 
                    [
                        'value' => $profile->contacts->chief_position,
                        'label' => t('Head position','company'),
                    ],                    
                    [
                        'value' => $profile->contacts->chief_fio,
                        'label' => t('Head full name','company'),
                    ],
                    [
                        'value' => $profile->contacts->chief_phone,
                        'label' => t('Head phone','company'),
                    ],                    
                    [
                        'value' => $profile->contacts->chief_email,
                        'label' => t('Head email','company'),
                    ], 
                    [
                        'group'=>true,
                        'label'=> t('Project manager','company'),
                        'rowOptions'=>['class'=>'table-agro-subhead']
                    ], 
                    [
                        'value' => $profile->contacts->manager_position,
                        'label' => t('Manager\'s position','company'),
                    ],                    
                    [
                        'value' => $profile->contacts->manager_fio,
                        'label' => t('Manager\'s full name','company'),
                    ],
                    [
                        'value' => $profile->contacts->manager_phone,
                        'label' => t('Manager\'s phone','company'),
                    ],
                    [
                        'value' => $profile->contacts->manager_fax,
                        'label' => t('Manager\'s fax','company'),
                    ],                    
                    [
                        'value' => $profile->contacts->manager_email,
                        'label' => t('Manager\'s email','company'),
                    ], 
                    [
                        'group'=>true,
                        'label'=> t('Signer (used in proposal)','company'),
                        'rowOptions'=>['class'=>'table-agro-subhead']
                    ], 
                    [
                        'value' => $profile->contacts->proposal_signature_name,
                        'label' => t('Signer\'s full name','company'),
                    ],                    
                    [
                        'value' => $profile->contacts->proposal_signature_post,
                        'label' => t('Signer\'s position','company'),
                    ],                     
                    [
                        'group'=>true,
                        'label'=> t('Bank details','company'),
                        'rowOptions'=>['class'=>'table-agro-head']
                    ],
                    [
                        'value' => $profile->bankDetails->rs_schet,
                        'label' => t('Checking account','company'),
                    ],
                    [
                        'value' => $profile->bankDetails->ks_schet,
                        'label' => t('Correspondent account','company'),
                    ],
                    [
                        'value' => $profile->bankDetails->bik,
                        'label' => t('BIC','company'),
                    ],
                    [
                        'value' => $profile->bankDetails->bank_info,
                        'label' => t('Bank information','company'),
                    ],                    
                ],
            ]); ?>
        </div>
    </div>
</div>
</div>
