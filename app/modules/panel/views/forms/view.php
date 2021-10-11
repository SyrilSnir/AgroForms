<?php

use app\core\helpers\View\Form\FormStatusHelper;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\SearchModels\Forms\FieldSearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use kotchuprik\sortable\grid\Column;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Form */
/* @var $formFieldsDataProvider ActiveDataProvider */
/* @var $formFieldsModel FieldSearch */

$this->title = $model->name;
?>
<div class="category-view">
    <p>
        <?= Html::a(Yii::t('app', 'Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($model->form_type_id !== FormType::SPECIAL_STAND_FORM):?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete the form?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'title:text:' . Yii::t('app', 'Title'),
                    'name:text:' . Yii::t('app', 'Name'),
                    'description:raw:' . Yii::t('app', 'Description'),
                    'slug:text:' . Yii::t('app','Character code'),
                    'formType.name:text:' . Yii::t('app/requests', 'Form type'),
                    [
                        'attribute' => 'has_file',
                        'label' => Yii::t('app','File attachment available'),
                        'value' => $model->has_file ? t('Yes') : t('No')
                    ],
                    [
                        'attribute' => 'status',
                        'label' => t('Status'),
                        'format' => 'raw',
                        'value' => FormStatusHelper::getStatusLabel($model->status)
                    ],
                    [
                        'attribute' => 'exhibition_id',
                        'label' => Yii::t('app','Available for exhibitions'),
                        'format' => 'raw',
                        'value' => $model->exhibition->title
                    ],                        
                    'valute.name:text:' . t('Valute'),
                    
                ],
            ]); ?>
    </div>
</div>

