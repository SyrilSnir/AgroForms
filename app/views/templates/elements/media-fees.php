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
        <tr>
            <?php foreach ($mediaFees as $item): ?>
            <td><?php echo $item->mediaFeeType->name ?></td>
            <td><?php echo $item->count ?></td>        
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>
