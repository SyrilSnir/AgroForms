<?php

use app\models\ActiveRecord\Contract\Contracts;
use app\models\ActiveRecord\Requests\Request;
/* @var $model Request */
/** @var Contracts|null $contract */
$contract = $model->contract;
?>
<table  style="width:100%; font-family: Verdana;">
    <tr style="font-size: 10pt">
        <?php if ($contract && $contract->show_in_requests): ?>
        <td style="text-align: left;color:black;"><span><?php echo t('Exhibitor','exhibitions');?>: </span></td>
        <?php else: ?>
        <td style="text-align: left;color:black;"><span><?php echo t('Customer','exhibitions');?>: </span></td>
        <?php endif; ?>
        <td style="text-align: right;color:black;"><span><?php echo $model->user->company->full_name ?></span></td>
    </tr>
    <tr style="font-size: 18pt">
        <td style="font-size: 18pt;text-align: left;color:black;"><span><?php echo $model->form->name ?></span></td>
        <td style="font-size: 18pt;text-align: right;color:black;"><span><b><?php echo mb_convert_case($model->form->title,MB_CASE_UPPER) ?></b></span></td>
    </tr>    
</table>
