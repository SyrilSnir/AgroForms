<?php

use app\core\helpers\View\YesNoStatusHelper;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\FieldEnum;
use app\models\ActiveRecord\Forms\SpecialPrice;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Field */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = $model->name;

?>
<div class="category-view">
    <p>
        <?= Html::a(Yii::t('app','Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete the field?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app','Back'), ['/panel/forms/update', 'id' => $model->form_id ], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name:text:' . Yii::t('app','Name'),
                'description:text:' . Yii::t('app','Description'),
                'form.name:text:' . Yii::t('app', 'Form'),
                'elementType.name:text:' . Yii::t('app', 'Element type'),
                [
                      'attribute' => 'showed_in_request',
                      'label' => Yii::t('app', 'Show in application'),
                      'format' => 'raw',
                      'value' => YesNoStatusHelper::getStatusLabel($model->showed_in_request)
                ],                 
                [
                      'attribute' => 'showed_in_pdf',
                      'label' => Yii::t('app', 'Show in printed form'),
                      'format' => 'raw',
                      'value' => YesNoStatusHelper::getStatusLabel($model->showed_in_pdf)
                ], 
                [
                      'attribute' => 'to_export',
                      'label' => Yii::t('app', 'Add to export'),
                      'format' => 'raw',
                      'value' => YesNoStatusHelper::getStatusLabel($model->to_export)
                ],                 
                [
                      'attribute' => 'published',
                      'label' => Yii::t('app','Available for publication on the site'),
                      'format' => 'raw',
                      'value' => YesNoStatusHelper::getStatusLabel($model->published)
                ],                 
            ],
        ]); ?>
    </div>
</div>
<div class="card">
    <div class="card-header">        
        <div class="card-title"><?php echo Yii::t('app', 'Extra options') ?></div>
    </div>           
    <div class="card-body">
        <?php
        
$attributes = $model->fieldParams->getViewParameters();


echo DetailView::widget([
    'model' => $model->fieldParams,
    'attributes' => $attributes,
]);        
        ?>
    </div>
</div>
    <?php if(in_array($model->element_type_id,ElementType::COMPUTED_FIELDS )): ?>
        <?php 
    $specialPricesQuery = SpecialPrice::find()->where(['field_id' => $model->id]);
    $specialPricesProvider = new ActiveDataProvider([
        'query' => $specialPricesQuery,
        'sort' => false,      
    ]);          
        ?>
<div class="card">
    <div class="card-header">        
        <div class="card-title"><?php echo t('Special price rules') ?></div>
    </div>           
    <div class="card-body">  
    <?php 
    echo GridView::widget([
        'columns' => [
            'start_date:date:' . Yii::t('app', 'Start date'),
            'end_date:date:' . Yii::t('app', 'End date'), 
            'price:text:' . Yii::t('app', 'Price'),
        ],

        'dataProvider'=>$specialPricesProvider,                
    ]);     
    ?>         
    </div>           
</div> 
<?php endif; ?>
    <?php if(in_array($model->element_type_id,ElementType::HAS_ENUM_ATTRIBUTES)): ?>    
    
<?php 
    $query = FieldEnum::find()->where(['field_id' => $model->id]);
    $fieldEnumProvider = new ActiveDataProvider([
        'query' => $query,
        'sort' => false,      
    ]);      
?>
    

<div class="card">
    <div class="card-header">        
        <div class="card-title"><?php echo t('Enumerated items') ?></div>
    </div>           
    <div class="card-body">  
    <?php 
    echo GridView::widget([
        'columns' => [
            'name',
            'value'
        ],

        'dataProvider'=>$fieldEnumProvider,                
    ]);     
    ?>         
    </div>           
</div>
    <?php endif; ?>


