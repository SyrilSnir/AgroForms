<?php 

use app\models\ActiveRecord\Requests\Request;
/* @var $model Request */
?>
<table  style="width:100%; font-family: Verdana;">
    <tr style="font-size: 10pt">
        <td style="text-align: left;"><span><?php echo t('Exhibitor','exhibitions');?>: </span></td>
        <td style="text-align: right;"><span><?php echo $model->user->company->name ?></span></td>
    </tr>
    <tr style="font-size: 18pt">
        <td style="font-size: 18pt;text-align: left;"><span><?php echo $model->form->name ?>: </span></td>
        <td style="font-size: 18pt;text-align: right;"><span><b><?php echo mb_convert_case($model->form->title,MB_CASE_UPPER) ?></b></span></td>
    </tr>    
</table>
