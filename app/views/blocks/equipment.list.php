<?php 

/** @var array $values */
$fullPrice = 0;
?>
<table class="table table-bordered">
    <thead>                  
      <tr>                      
        <th style="width: 15px">Код</th>
        <th>Наименование</th>
        <th>Количество</th>
        <th>Цена зв ед.</th>
        <th>Стоимость</th>
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
      <tr style="background: lightgoldenrodyellow">
          <td colspan="4">Итого:</td>
          <td><?php echo number_format($fullPrice, 0, '.', ' ') ?></td>
      </tr>
      </tbody>

</table>