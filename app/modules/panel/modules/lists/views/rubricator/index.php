<?php

use app\models\ActiveRecord\Nomenclature\Rubricator;
use app\models\SearchModels\Nomenclature\RubricatorSearch;
use wbraganca\fancytree\FancytreeWidget;
use yii\data\ActiveDataProvider;
use yii\web\JsExpression;
use yii\web\View;


/* @var $this View */
/* @var $searchModel RubricatorSearch */
/* @var $dataProvider ActiveDataProvider */
$tree = Rubricator::findOne(1)->tree();
?>
<div class="col-md-6">            
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Рубриактор</h3>
        </div>                
        <div class="card-body">
            <?php
echo FancytreeWidget::widget([
        'options' =>[
                'source' => $tree,
                'extensions' => [],
                'dblclick' => new JsExpression('function(event,data) {
                    $.post("/panel/lists/rubricator/update-ajax",{id: data.node.data.id}).done(function(data) {
                        console.log("DONE",data); 
                        $("#rubricator-form").html(data);
                    } ).catch(function(e) {
                        console.log("Не найден раздел рубрикатора");
                    });
                    console.log("DBLCLICK", event,data.node.data.id)    }')
                /*'dnd' => [
                        'preventVoidMoves' => true,
                        'preventRecursiveMoves' => true,
                        'autoExpandMS' => 400,
                        'dragStart' => new JsExpression('function(node, data) {
                                return true;
                        }'),
                        'dragEnter' => new JsExpression('function(node, data) {
                                return true;
                        }'),
                        'dragDrop' => new JsExpression('function(node, data) {
                                data.otherNode.moveTo(node, data.hitMode);
                        }'),
                ],*/            
        ]
]);           
            ?>
        </div>
    </div>            
</div>
<div id="rubricator-form" class="col-md-6">            

</div>
<!--
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Рубриактор</h3>
        </div>                
        <div class="card-body">
        </div>
    </div>-->