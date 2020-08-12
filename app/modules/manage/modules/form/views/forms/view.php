<?php

use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\SearchModels\Forms\FieldSearch;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
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
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить форму?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Вернуться', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><?php echo $this->title ?></h3>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title:text:Заголовок',
                    'name:text:Наимменование',
                    'description:raw:Описание',
                    'formType.name:text:Тип формы',
                    'order:text:Порядковый номер',
                    'valute.name:text:Валюта',
                    
                ],
            ]); ?>
        </div>
    </div>
</div>
<?php if (in_array($model->form_type_id, FormType::HAS_DYNAMIC_FIELDS)): ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo 'Список полей' ?></h3>
        </div>
        <div class="bd-example">    
            <p><?= Html::a('Добавить поле', ['fields/create', 'formId' => $model->id], ['class' => 'btn btn-success']) ?></p>
        </div>
        <div class="card-body">

                <?= GridView::widget([
                    'dataProvider' => $formFieldsDataProvider,
                    'filterModel' => $formFieldsModel,
                    'columns' => [  
                        'order:text:Позиция',
                        'name:text:Название',
                        [
                            'label' => 'Группа',
                            'filter' => $formFieldsModel->fieldGroupList(),
                            'attribute' => 'fieldGroupId',
                            'value' => function (Field $model) {
                                return $model->fieldGroup ? $model->fieldGroup->name:
                                        'Не задана';
                            }
                        ],
                        'description:text:Описание',
                        
                        [
                            'label' => 'Тип элемента',
                            'attribute' => 'elementTypeId',
                            'filter' => $formFieldsModel->elementTypesList(),
                            'value' => function (Field $model) {
                                    return $model->elementType->name;
                                }
                            ],
                        [
                            'class' => ActionColumn::class,
                            'header' => 'Действия',
                            'controller' => 'fields'                       
                        ],
                    ],
                ]); ?>
        </div>
    </div>  
<?php endif; ?>

