<?php

use app\core\helpers\View\Request\RequestStatusHelper;
use app\models\ActiveRecord\Requests\Request;
use yii\web\View;

/* @var $model Request */
/* @var $this View */
/* @var $fields array */

$this->title = '';
?>
<h2 style="text-align: right"><span style="border-bottom: 1px solid black;"><?php echo t('Application №','requests') . $model->id; ?></span></h2>
<h2 style="text-align: center"><span><?php echo $model->form->headerName; ?></span></h2>

<ul style="list-style: none">
    <li><span><?php echo t('Company','company') ?> : </span><span><?php echo $model->user->company->name ?></span></li>
    <li><span><?php echo t('Member email','user') ?> : </span><span><?php echo $model->user->email ?></span></li>
    <li><span><?php echo t('Status')?> : </span><span><?php echo RequestStatusHelper::getStatusLabel($model->status) ?></span></li>    
</ul>

<table class="table">
    <thead>
    </thead>    
    <tbody>        
    <?php foreach ($fields as $field): ?>
    <tr><td><?php echo $field['label']?></td><td><?php echo $field['value']?></td></tr>
    <?php endforeach; ?>
    </tbody>
</table>


