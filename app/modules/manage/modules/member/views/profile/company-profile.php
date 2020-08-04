<?php

use app\models\ActiveRecord\Companies\Company;
use kartik\detail\DetailView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $profile Company */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $profile->name;
?>
<div class="category-view full-view">
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><?php echo $this->title ?></h3>
        <div class="card-body">
            <?= DetailView::widget([
                'mode'=>DetailView::MODE_VIEW,               
                'model' => $profile,
                'attributes' => [
                    [
                        'group'=>true,
                        'label'=>'О компании',
                        'rowOptions'=>['class'=>'table-info']
                    ],
                    'id',
                    'name:text:Название',
                    'full_name:text:Полное наименование',
                    'inn:text:ИНН',
                    'kpp:text:КПП',
                    'phone:text:Телефон',
                    'fax:text:Факс',
                    'site:text:Сайт',
                    [
                        'group'=>true,
                        'label'=>'Адрес',
                        'rowOptions'=>['class'=>'table-info']
                    ],
                    [
                        'group'=>true,
                        'label'=>'Юридический адрес',
                        'rowOptions'=>['class'=>'table-success']
                    ],
                    [
                        'value' => $profile->legalAddress->index,
                        'label' => 'Почтовый индекс'
                    ],                  
                    [
                        'value' => $profile->legalAddress->adds,
                        'label' => 'Адрес'
                    ],
                    [
                        'value' => $profile->legalAddress->city->name,
                        'label' => 'Город'                        
                    ],
                    [
                        'group'=>true,
                        'label'=>'Почтовый адрес',
                        'rowOptions'=>['class'=>'table-success']
                    ],
                    [
                        'value' => $profile->postalAddress->index,
                        'label' => 'Почтовый индекс'
                    ],                  
                    [
                        'value' => $profile->postalAddress->adds,
                        'label' => 'Адрес'
                    ],
                    [
                        'value' => $profile->postalAddress->city->name,
                        'label' => 'Город'                        
                    ],
                    [
                        'group'=>true,
                        'label'=>'Контакты',
                        'rowOptions'=>['class'=>'table-info']
                    ],
                    [
                        'group'=>true,
                        'label'=>'Руководитель компании',
                        'rowOptions'=>['class'=>'table-success']
                    ], 
                    [
                        'value' => $profile->contacts->chief_position,
                        'label' => 'Дожность руководителя'
                    ],                    
                    [
                        'value' => $profile->contacts->chief_fio,
                        'label' => 'ФИО руководителя'
                    ],
                    [
                        'value' => $profile->contacts->chief_phone,
                        'label' => 'Телефон руководителя'
                    ],                    
                    [
                        'value' => $profile->contacts->chief_email,
                        'label' => 'Email руководителя'
                    ], 
                    [
                        'group'=>true,
                        'label'=>'Менеджер проекта',
                        'rowOptions'=>['class'=>'table-success']
                    ], 
                    [
                        'value' => $profile->contacts->manager_position,
                        'label' => 'Дожность менеджера'
                    ],                    
                    [
                        'value' => $profile->contacts->manager_fio,
                        'label' => 'ФИО менеджера'
                    ],
                    [
                        'value' => $profile->contacts->manager_phone,
                        'label' => 'Телефон менеджера'
                    ],
                    [
                        'value' => $profile->contacts->manager_fax,
                        'label' => 'Факс менеджера'
                    ],                    
                    [
                        'value' => $profile->contacts->manager_email,
                        'label' => 'Email менеджера'
                    ], 
                    [
                        'group'=>true,
                        'label'=>'Банковские реквизиты',
                        'rowOptions'=>['class'=>'table-info']
                    ],
                    [
                        'value' => $profile->bankDetails->rs_schet,
                        'label' => 'Расчетный счет'
                    ],
                    [
                        'value' => $profile->bankDetails->ks_schet,
                        'label' => 'Корреспондентскй счет'
                    ],
                    [
                        'value' => $profile->bankDetails->bik,
                        'label' => 'БИК'
                    ],
                    [
                        'value' => $profile->bankDetails->bank_info,
                        'label' => 'Информация о банке'
                    ],                    
                ],
            ]); ?>
        </div>
    </div>
</div>
</div>
