<?php 

use app\models\ActiveRecord\Contract\ContractMediaFees;

/** @var ContractMediaFees[] $mediaFees */
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 150px"><?php echo t('Type of media contributions') ?></th>
            <th style="width: 50px"><?php echo t('Quantity, pcs.') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mediaFees as $item): ?>
        <tr>
            <td><?php echo $item->mediaFeeType->name ?></td>
            <td><?php echo $item->count ?></td>        
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
