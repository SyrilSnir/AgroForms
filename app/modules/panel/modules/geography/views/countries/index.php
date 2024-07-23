<?php

use app\core\helpers\Utils\users\RolesHelper;
use app\models\Data\Operations;
use app\models\SearchModels\Geografy\CountrySearch;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel CountrySearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app/title','Directory of countries');
$user = RolesHelper::getUser();
$action = Yii::$app->getRequest()->getPathInfo();
$rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
$toolbarContent = $rowsCountTemplate;
if ($user->canOperation(Operations::ENTITY_COMPANY, Operations::OP_CREATE)) {
    $toolbarContent .= Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app/title', 'New country'),
                                ]);
}
$columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $toolbarContent
                            
                        ],
                    ],     
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [  
                        ['class' => SerialColumn::class],
                        'name:text:' . Yii::t('app','Country name'),
                        'code:text:' . Yii::t('app','Identifier'),
                        [
                            'class' => ActionColumn::class,
                            'visibleButtons' => [
                                'delete' => $user->canOperation(Operations::ENTITY_COMPANY, Operations::OP_DELETE),
                                'updete' => $user->canOperation(Operations::ENTITY_COMPANY, Operations::OP_EDIT),
                                
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

