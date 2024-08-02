<?php 
/** @var string $exhibitionName */
/** @var string $contractNumber */
/** @var string $dateOfContract */
/** @var bool $showContract */

?>
<table  style="width:100%; font-family: Verdana;font-size: 8pt">
    <tr>
        <td style="color:black;text-align: left;"><span><?php echo t('Exhibition');?>: </span><span><b><?php echo $exhibitionName ?></b></span></td>
        <?php if ($showContract): ?>
        <td style="color:black;text-align: right;"><span><?php echo t('Attachment to agreement', 'contracts') . ' № ' . $contractNumber . ' ' . t('dated','contracts') .' ' . $dateOfContract ?></span></td>
        <?php endif; ?>
    </tr>
</table>