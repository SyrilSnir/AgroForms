<?php
use yii\grid\ActionColumn;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\SearchModels\Users\ManagerRoleSearch;

/* @var $this yii\web\View */
/* @var $searchModel ManagerRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<section class="content">
    <div class="card">
<?php 
    $this->title = Yii::t('app/title','Roles for managers');
    $action = Yii::$app->getRequest()->getPathInfo();
    $rowsCountTemplate = require Yii::getAlias('@elements') . DIRECTORY_SEPARATOR . 'page-counter.php';
    $gridConfig = require Yii::getAlias('@config') . DIRECTORY_SEPARATOR . 'kartik.gridview.php';  
    $columnsConfig = [
                    'toolbar' => [
                        [
                            'content'=> $rowsCountTemplate .
                                Html::a('<i class="fas fa-plus"></i>',['create'], [
                                    'class' => 'btn btn-sm btn-success',
                                    'title' => Yii::t('app', 'Add role'),
                                ])                            
                        ],
                    ],      
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,   
                    'columns' => [                    
                        'name:text:' . Yii::t('app', 'Role name'),
                        ['class' => ActionColumn::class],
                    ],        
        ];
    $fullGridConfig = array_merge($columnsConfig,$gridConfig);    
    
 ?>
        <div class="card-body">
<?= GridView::widget($fullGridConfig); ?>
        </div>
    </div>
</section>


