<?php

use app\models\ActiveRecord\Nomenclature\Rubricator;
use app\models\SearchModels\Nomenclature\RubricatorSearch;
use wbraganca\fancytree\FancytreeWidget;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;


/* @var $this View */
/* @var $showAll bool */
/* @var $searchModel RubricatorSearch */
/* @var $dataProvider ActiveDataProvider */
$tree = Rubricator::findOne(1)->sortedTree($showAll);
//$tree = Rubricator::findOne(1)->tree();
?>
<div class="col-md-6">            
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Рубриактор</h3>
            <div class="buttons__wrappper">
            <?php 
    echo Html::button('Новый раздел',[
                                    'class' => 'btn btn-sm btn-success',
                                    'onclick' => '(function(event) {
                    $.post("/panel/lists/rubricator/create-ajax").done(function(data) {
                        $("#rubricator-form").html(data);
                        }); 
                    })();'
                                ]);            
            ?>
                <?php if ($showAll) :?>
<a class="btn btn-sm btn-outline-secondary" href="/panel/lists/rubricator/index" title="<?php echo t('Hide deleted sections')?>"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                <?php else:  ?>
<a class="btn btn-sm btn-outline-secondary" href="/panel/lists/rubricator/index/?showAll=true" title="<?php t('Show deleted sections') ?>"><i class="fas fa-trash" aria-hidden="true"></i></a>
                <?php endif; ?>
             </div>
        </div>                
        <div class="card-body">
            <?php
echo FancytreeWidget::widget([
        'options' =>[
                'source' => $tree,
                'extensions' => ['dnd5'],
                'dblclick' => new JsExpression('function(event,data) {
                    $.post("/panel/lists/rubricator/update-ajax",{id: data.node.data.id}).done(function(data) {
                        $("#rubricator-form").html(data);
                    } ).catch(function(e) {
                    });
                }'),
                'dnd5' => [
                        'preventVoidMoves' => true,
                        'preventRecursion' => true,
                        'preventSameParent' => false,
                        'preventNonNodes' => true,
                        'preventForeignNodes' => true,
                        'preventRecursion' => false,
                        'autoExpandMS' => 400,
                        'dragStart' => new JsExpression('function(node, data) {
                                return true;
                        }'),
                        'dragEnter' => new JsExpression('function(node, data) {
   if (node.parent !== data.otherNode.parent) {
     return false;
   }
  return ["before", "after"];
                        }'),
                        'dragDrop' => new JsExpression('function(node, data) {
                            console.log("DRAGDROP", data.otherNode.data.id, node.data.id);
                            $.get("/panel/lists/rubricator/move", {
                                item:  data.otherNode.data.id,
                                second: node.data.id,
                                action: data.hitMode
                            });
                            data.otherNode.moveTo(node, data.hitMode);
                        }'),
                ],
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