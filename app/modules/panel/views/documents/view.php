<?php

use app\core\helpers\Utils\users\RolesHelper;
use app\models\ActiveRecord\Document\Documents;
use app\models\Data\Operations;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Documents */
/* @var $modificationsProvider ActiveDataProvider */

$this->title = t('Document') . ' № ' .$model->id;
$user = RolesHelper::getUser();
?>
<div class="category-view">
    <p>
        <?php if ($user->canOperation(Operations::ENTITY_DOCUMENT, Operations::OP_EDIT)): ?>
        <?= Html::a(Yii::t('app','Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if ($user->canOperation(Operations::ENTITY_DOCUMENT, Operations::OP_DELETE)): ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete the document?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app','Back'), ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>
<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'title:text:' . Yii::t('app', 'Title'),
                'description:text:' . Yii::t('app', 'Description'),                
                'company.name:text:' . t('Company','user'),
                'exhibition.title:text:' . t('Exhibition'),
                'created_at:date:' . Yii::t('app','Date added'),
                [
                    'attribute' => 'file',
                    'label' => Yii::t('app', 'File'),
                    'format' => 'raw',
                    'value' => Html::a($model->file, $model->getUploadedFileUrl('file'))
                ],                
            ],
        ]); ?>
    </div>
</div>
</div>

