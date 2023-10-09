<?php 
/** @var [] $urls */
/** @var string $fieldName */
/** @var bool $isComputed */
/** @var int $price */
/** @var string $valute */
?>
<?php  foreach ($urls as $url): ?>
<tr>
  <th style="color:black;font-size: 8pt;width: 15px"><?= $fieldName ?></th>
  <td style="font-size: 8pt;width: 15px"><a class="attachment-catalog" href="<?= $url ?>"><?= $url ?></a></td>
</tr> 
<?php endforeach; ?>
      <?php if($isComputed):  ?>
      <tr  style="color:black;font-size: 9pt;width: 15px">
          <td><?php echo t('Total','requests') ?>:</td>
          <td style="text-align: right"><?php echo number_format($price, 0, '.', ' ') . ' ' . $valute ?></td>
      </tr>
      <?php endif; ?>