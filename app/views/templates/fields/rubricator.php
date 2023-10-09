<?php
/** @var [] $valuesList */
/** @var boolean $isComputed */
/** @var boolean $isRussian */
/** @var string $valute */
/** @var int $price */
    $index = 0;
    ?>
<table class="table table-bordered">
    <thead>
      <tr> 
        <th style="width: 15px"><?php echo t('Serial number') ?></th>
        <th style="text-align: left"><?php echo t('Rubric') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($valuesList as $element):?>
      <tr>
          <td><?php echo ++$index; ?></td>
          <td><?php echo $isRussian ? $element['name']: $element['nameEng']; ?></td>
      </tr>              
      <?php endforeach; ?>
      <?php if($isComputed):  ?>
      <tr style="font-weight: 600">
          <td><?php echo t('Total','requests') ?>:</td>
          <td style="text-align: right"><?php echo number_format($price, 0, '.', ' ') . ' ' . $valute ?></td>
      </tr>
      <?php endif; ?>
      </tbody>

</table>

