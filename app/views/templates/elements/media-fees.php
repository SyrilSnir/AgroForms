<?php 

use app\models\ActiveRecord\Contract\ContractMediaFees;

/** @var ContractMediaFees[] $mediaFees */
?>
<table class="table table-bordered">
    <tbody>
        <?php foreach ($mediaFees as $item): ?>
        <tr>
            <td><?php echo $item->mediaFeeType->name ?></td>
            <td><?php echo $item->count ?></td>        
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
