<?php

use app\core\helpers\View\YesNoStatusHelper;
use app\models\ActiveRecord\Nomenclature\Rubricator;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var Rubricator $model */
$this->title = $model->name;
$attributes = [
                'name:text:' . Yii::t('app','Name'),
                'parent.name:text:' . Yii::t('app','Parent section'),
            ];
if ($model->isLeaf()) {
    $attributes[] = [                    
                        'attribute' => 'is_agrocomponent',
                        'label' => t('Agrocomponent'),
                        'format' => 'raw',
                        'value' => YesNoStatusHelper::getStatusLabel($model->is_agrocomponent),
                    ];    
}
?>
<div class="category-view">
    <p>
        <?= Html::a(Yii::t('app','Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => $attributes,
        ]); ?>
    </div>
</div>
