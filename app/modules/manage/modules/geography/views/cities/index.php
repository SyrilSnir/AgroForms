<?php
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\SearchModels\Geography\CitySearch;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление городами';
$action = Yii::$app->getRequest()->getPathInfo();
?>
<section class="content">
    <div class="card">
<?php 
    $rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
// Добавление нового пользователя из панели администратора не имеет смысла
/* ?>
    <p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php */ ?>
        <div class="bd-example">
           
                <p><?= Html::a('Новый город', ['create'], ['class' => 'btn btn-success']) ?></p>
            
    </div>
        <div class="card-body">

                <?= GridView::widget([
   'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],  
    'panel' => [
        'type' => GridView::TYPE_DEFAULT,
        'heading' => $this->title,
    ],                    
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate
                        ],
                    ], 
                    'toggleDataContainer' => ['class' => 'btn-group-sm'],                     
                    'dataProvider' => $dataProvider,
                    'pager' => require Yii::getAlias('@config') . DIRECTORY_SEPARATOR .'pager.php',
                    'filterModel' => $searchModel,
                    'columns' => [                    
                        'name:text:Название города',
                        [
                            'attribute' => 'regionId',
                            'label' => 'Регион',
                            'width' => '20rem',
                            'filter' => $searchModel->getRegions(),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'value' => 'region.name'                            
                        ],
                        [
                            'attribute' => 'countryId',
                            'label' => 'Страна',
                            'width' => '15rem',
                            'filter' => $searchModel->getCountries(),
                            'filterType' => GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'options' => ['prompt' => ''],
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'value' => 'country.name'
                        ],
                        ['class' => ActionColumn::class],
                    ],
                ]); ?>
        </div>
    </div>
</section>

