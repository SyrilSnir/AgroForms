<?php

use app\models\SearchModels\Companies\CompanySearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use kartik\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel CompanySearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/company','Directory of companies');
$this->params['breadcrumbs'][] = $this->title;
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app/company', 'Add company'),
                                ])                            
                        ],
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [                    
                        'name:text:'. Yii::t('app/company', 'Name'),
                        'full_name:text:'. Yii::t('app/company', 'Full name'),
                        [
                            'class' => ActionColumn::class,
                            'width' => '100px',
                            'visibleButtons' => [
                                'delete' => Yii::$app->user->can('adminMenu')
                            ]                            
                        ],
                    ],
                ];
$gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';
$fullGridConfig = array_merge($columnsConfig,$gridConfig);
?>
<section class="content">
    <div class="card">
        <div class="card-body">
                <?= GridView::widget($fullGridConfig); ?>
        </div>
    </div>
</section>

