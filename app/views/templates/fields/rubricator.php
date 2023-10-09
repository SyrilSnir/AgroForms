<?php
/** @var [] $valuesList */
/** @var boolean $isComputed */
/** @var boolean $isRussian */
/** @var string $title */
/** @var string $valute */
/** @var int $price */
    $index = 0;
    ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="2"><?= $title ?></th>            
        </tr>
    <tbody>
      <?php foreach ($valuesList as $element):?>
      <tr>
          <td><?php echo ++$index; ?></td>
          <td><?php echo $isRussian ? $element['name']: 
                        (key_exists('nameEng', $element) ? 
                            $element['nameEng'] : 
                            $element['name']); ?></td>
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

