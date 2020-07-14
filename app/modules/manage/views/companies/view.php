<?php

use app\models\ActiveRecord\Companies\Company;
use kartik\detail\DetailView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $model Company */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->name;
?>
<div class="category-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить участника', ['add-member', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><?php echo $this->title ?></h3>
        <div class="card-body">
            <?= DetailView::widget([
                'mode'=>DetailView::MODE_VIEW,               
                'model' => $model,
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
                        'value' => $model->legalAddress->index,
                        'label' => 'Почтовый индекс'
                    ],                  
                    [
                        'value' => $model->legalAddress->adds,
                        'label' => 'Адрес'
                    ],
                    [
                        'value' => $model->legalAddress->city->name,
                        'label' => 'Город'                        
                    ],
                    [
                        'group'=>true,
                        'label'=>'Почтовый адрес',
                        'rowOptions'=>['class'=>'table-success']
                    ],
                    [
                        'value' => $model->postalAddress->index,
                        'label' => 'Почтовый индекс'
                    ],                  
                    [
                        'value' => $model->postalAddress->adds,
                        'label' => 'Адрес'
                    ],
                    [
                        'value' => $model->postalAddress->city->name,
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
                        'value' => $model->contacts->chief_position,
                        'label' => 'Дожность руководителя'
                    ],                    
                    [
                        'value' => $model->contacts->chief_fio,
                        'label' => 'ФИО руководителя'
                    ],
                    [
                        'value' => $model->contacts->chief_phone,
                        'label' => 'Телефон руководителя'
                    ],                    
                    [
                        'value' => $model->contacts->chief_email,
                        'label' => 'Email руководителя'
                    ], 
                    [
                        'group'=>true,
                        'label'=>'Менеджер проекта',
                        'rowOptions'=>['class'=>'table-success']
                    ], 
                    [
                        'value' => $model->contacts->manager_position,
                        'label' => 'Дожность менеджера'
                    ],                    
                    [
                        'value' => $model->contacts->manager_fio,
                        'label' => 'ФИО менеджера'
                    ],
                    [
                        'value' => $model->contacts->manager_phone,
                        'label' => 'Телефон менеджера'
                    ],
                    [
                        'value' => $model->contacts->manager_fax,
                        'label' => 'Факс менеджера'
                    ],                    
                    [
                        'value' => $model->contacts->manager_email,
                        'label' => 'Email менеджера'
                    ], 
                    [
                        'group'=>true,
                        'label'=>'Банковские реквизиты',
                        'rowOptions'=>['class'=>'table-info']
                    ],
                    [
                        'value' => $model->bankDetails->rs_schet,
                        'label' => 'Расчетный счет'
                    ],
                    [
                        'value' => $model->bankDetails->ks_schet,
                        'label' => 'Корреспондентскй счет'
                    ],
                    [
                        'value' => $model->bankDetails->bik,
                        'label' => 'БИК'
                    ],
                    [
                        'value' => $model->bankDetails->bank_info,
                        'label' => 'Информация о банке'
                    ],                    
                ],
            ]); ?>
        </div>
    </div>


</div>

