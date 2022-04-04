<?php

use app\core\helpers\View\Form\FormElements\FormElementInterface;
use app\core\helpers\View\Request\RequestStatusHelper;
use app\models\ActiveRecord\Requests\Request;
use yii\web\View;

/* @var $model Request */
/* @var $this View */
/* @var $fields FormElementInterface[] */
/** @var array $values */

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
    <tbody style="text-align: right">        
    <?php foreach ($fields as $field): ?>
        <?php 
            if (!$field->isShowInRequest()) {
                continue;
            }
            $fieldId = $field->getFieldId();
            $val = [];
            if (key_exists($fieldId, $values)) {
                $val = $values[$fieldId];
            }
            $result = $field->renderPDF($val);
            
        ?>
            <?php if(!empty($result)) :?>
                <tr><td style="text-align: right"><?php echo $result ?></td></tr>
            <?php endif; ?>
    <?php endforeach; ?>
            <?php if ($model->form->formType !== app\models\ActiveRecord\Forms\FormType::DYNAMIC_INFORMATION_FORM):?>      
                <tr>
                    <td style="text-align: right;font-weight:bold"><?php echo t('Total amount payable','requests') .': '.  $model->application->amount . ' ' . $model->form->valute->symbol ?></td>
                        
                    </tr>
            <?php endif;?>
    </tbody>
</table>
