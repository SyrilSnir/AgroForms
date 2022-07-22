<?php 

/** @var array $values */
/** @var string $valute */
/** @var bool $isComputed Вычисляемое поле */
$fullPrice = 0;
?>
<table class="table table-bordered">
    <thead>
        <tr>            
            <th style="text-align: center" colspan="5"><?php echo $fieldName ?></th>
        </tr>
      <tr> 
          <th style="width: 15px"><?php echo t('Code','equipment') ?></th>
        <th><?php echo t('Name','equipment') ?></th>
        <th><?php echo t('Count','equipment') ?></th>
        <th><?php echo t('Unit price','equipment') ?></th>
        <th><?php echo t('Price','equipment') . ', ' . t($valute,'requests') ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($values as $element):?>
      <?php 
        $count = $element['count'] * $element['price'];
        $fullPrice+= $count;
      ?>
      <tr>
          <td><?php echo $element['code']; ?></td>
          <td><?php echo $element['name']; ?></td>
          <td><?php echo $element['count'] . ' ' . $element['unit']; ?></td>
          <td><?php echo $element['price']; ?></td>
          <td><?php echo number_format($count, 0, '.', ' ') ?></td>
      </tr>              
      <?php endforeach; ?>
      <?php if($isComputed):  ?>
      <tr style="font-weight: 600">
          <td colspan="4"><?php echo t('Total','requests') ?>:</td>
          <td><?php echo number_format($fullPrice, 0, '.', ' ') ?></td>
      </tr>
      <?php endif; ?>
      </tbody>

</table>