<?php
/** @var [] $valuesList */
/** @var boolean $isComputed */
/** @var boolean $isRussian */
/** @var string $title */
/** @var string $valute */
/** @var int $price */
    $index = 0;
    ?>
    <tr>
        <th style="color:black;font-size: 9pt;width: 15px" colspan="2"><?= $title ?></th>           
    </tr>
      <tr> 
        <th style="color:black;font-size: 8pt;width: 15px"><?php echo t('Serial number') ?></th>
        <th style="color:black;font-size: 8pt;width: 15px"><?php echo t('Rubric') ?></th>
      </tr>
      <?php foreach ($valuesList as $element):?>
      <tr>
          <td style="font-size: 8pt;width: 15px"><?php echo ++$index; ?></td>
          <td style="font-size: 8pt;width: 15px"><?php echo $isRussian ? $element['name']: 
                        (key_exists('nameEng', $element) ? 
                            $element['nameEng'] : 
                            $element['name']); ?></td>
      </tr>              
      <?php endforeach; ?>
      <?php if($isComputed):  ?>
      <tr  style="color:black;font-size: 9pt;width: 15px">
          <td><?php echo t('Total','requests') ?>:</td>
          <td style="text-align: right"><?php echo number_format($price, 0, '.', ' ') . ' ' . $valute ?></td>
      </tr>
      <?php endif; ?>
