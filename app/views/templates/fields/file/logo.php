<?php 
/** @var [] $urls */
/** @var string $fieldName */
/** @var bool $isComputed */
/** @var int $price */
/** @var string $valute */
?>
<?php        foreach ($urls as $url): ?>
<div class="logo-block clearfix">
<div class="attachment-pushed">
<h4 class="attachment-heading"><?= $fieldName ?>
</h4></div><img class="attachment-img" src="<?= $url ?>" alt="Логотип"></div>
<?php endforeach; ?>
      <?php if($isComputed && !empty($urls)):  ?>
<table class="table"><tbody>
      <tr style="font-weight: 600">
          <td><?php echo t('Total','requests') ?>:</td>
          <td style="text-align: right"><?php echo number_format($price, 0, '.', ' ') . ' ' . $valute ?></td>
      </tr></tbody></table>
      <?php endif; ?>
        

