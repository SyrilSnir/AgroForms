<?php 

/** @var array $values */
/** @var string $valute */
/** @var bool $isComputed Вычисляемое поле */
$fullPrice = 0;
?>
<tr style="border:none">
    <td colspan="2">
        
    
<table class="table">
    <thead>
        <tr>            
            <th style="color:black;font-size: 10pt;text-align: center" colspan="5"><?php echo $fieldName ?></th>
        </tr>
      <tr> 
          <th style="color:black;font-size: 8pt;width: 15px"><?php echo t('Code','equipment') ?></th>
        <th style="color:black;font-size: 8pt;"><?php echo t('Name','equipment') ?></th>
        <th style="color:black;font-size: 8pt;"><?php echo t('Count','equipment') ?></th>
        <th style="color:black;font-size: 8pt;"><?php echo t('Unit price','equipment') ?></th>
        <th style="color:black;font-size: 8pt;"><?php echo t('Price','equipment') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($values as $element):?>
      <?php 
        $count = $element['count'] * $element['price'];
        $fullPrice+= $count;
      ?>
      <tr>
          <td style="color:black;font-size: 8pt;"><?php echo $element['code']; ?></td>
          <td style="color:black;font-size: 8pt;"><?php echo $element['name']; ?></td>
          <td style="color:black;font-size: 8pt;"><?php echo $element['count'] . ' ' . $element['unit']; ?></td>
          <td style="color:black;font-size: 8pt;"><?php echo $element['price']. ' ' . t($valute,'requests'); ?></td>
          <td style="color:black;font-size: 8pt;text-align: right"><?php echo number_format($count, 0, '.', ' ') . ' ' . t($valute,'requests'); ?></td>
      </tr>              
      <?php endforeach; ?>
      <?php if($isComputed):  ?>
      <tr style="font-weight: 600">
          <td style="color:black;" colspan="4"><b><?php echo t('Total','requests') ?>:</b></td>
          <td style="color:black;font-size: 10pt;text-align: right"><?php echo number_format($fullPrice, 0, '.', ' ') .' ' .t($valute,'requests') ?></td>
      </tr>
      <?php endif; ?>
      </tbody>

</table>
    </td>
</tr>