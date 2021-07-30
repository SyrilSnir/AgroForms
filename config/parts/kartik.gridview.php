<?php

use kartik\grid\GridView;

return [
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'], 
    'toggleDataContainer' => ['class' => 'btn-group-sm'],      
    'panel' => [
        'type' => GridView::TYPE_DEFAULT,
    ],     
    'pager' => [       
        'maxButtonCount' => 10, // максимум 5 кнопок
        'options' => [
            'id' => 'mypager', 
            'class' => 'pagination pagination-sm'
        ],
        'nextPageLabel' => '<i class="fa fa-angle-right"></i>',
        'prevPageLabel' => '<i class="fa fa-angle-left"></i>',
        'lastPageLabel' => '<i class="fa fa-angle-double-right"></i>',
        'firstPageLabel' => '<i class="fa fa-angle-double-left"></i>',        
    ]
];

