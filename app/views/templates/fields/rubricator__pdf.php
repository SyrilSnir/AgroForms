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
        <th colspan="2" style="color:black;font-size: 9pt;width: 15px" colspan="2"></th>           
    </tr>
    <tr>
        <th colspan="2" style="color:black;font-size: 9pt;width: 15px" colspan="2"><?= $title ?></th>           
    </tr>
      <?php foreach ($valuesList as $element):?>
      <tr>
          <td colspan="2" style="font-size: 8pt;"><?php echo ++$index . '. '; ?><?php echo $isRussian ? $element['name']: 
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
