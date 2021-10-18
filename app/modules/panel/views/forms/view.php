<?php

use app\core\helpers\View\Form\FormStatusHelper;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\Forms\Manage\Forms\CopyForm;
use app\models\SearchModels\Forms\FieldSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Form */
/* @var $formFieldsDataProvider ActiveDataProvider */
/* @var $formFieldsModel FieldSearch */
$this->title = $model->name;

$anotherExhibitions = ArrayHelper::map(Exhibition::find()->andFilterWhere(['!=', 'id', $model->exhibition_id ])->orderBy('id')->asArray()->all(), 'id', 'title');
?>
<div class="category-view">
    <?php if (!empty($anotherExhibitions)): ?>
    <div class="clone-form-block">
        <?php $cloneExhibitionForm = ActiveForm::begin(['action' => ['copy']]); ?>
        <?php echo $cloneExhibitionForm->field($cloneForm, 'exhibitionId')->dropDownList($anotherExhibitions)->label(false); ?>
        <?php echo $cloneExhibitionForm->field($cloneForm, 'formId')->hiddenInput()->label(false); ?>
        <?php echo  Html::submitButton(t('Create copy'),[
             //'id' => 'form-copy',
            'class' => 'btn btn-secondary'
            ]) 
        ?>
        <?php ActiveForm::end(); ?>
    </div>
    <?php endif; ?>
    <p>
        <?= Html::a(Yii::t('app', 'Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($model->status === Form::STATUS_DRAFT): ?>
        <?= Html::a(Yii::t('app', 'Publish'), ['publish', 'id' => $model->id], ['class' => 'btn btn-success']) ?>        
        <?php endif; ?>
        <?php if ($model->status === Form::STATUS_ACTIVE): ?>
        <?= Html::a(Yii::t('app', 'To draft'), ['unpublish', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>        
        <?php endif; ?>        
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
    <div class="card">
        <div class="card-header">
            <h3><?php echo t('Form fields'); ?></h3>
        </div>    
        <div class="card-body">
            <?php 
    echo GridView::widget([
        'columns' => [
            'name:text:' . t('Name'),
            'elementType.name:text:' . t('Element type'),
        ],
        'dataProvider'=> $fieldDataProvider,               
    ]); 
            ?>
        </div>        
    </div>
</div>

