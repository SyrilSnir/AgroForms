<?php 
    /** @var string $title */
?>
<?php $index = 0; ?>
<?php foreach ($values as $value) :?>
            <tr>
                <th style="color:black;font-size: 9pt;width: 15px" colspan="2"><?= $title . ' №' . ++$index ?></th>           
            </tr>
        <tr>
          <th style="color:black;font-size: 8pt;width: 15px"><?= t('Site', 'company')?></th>
          <td style="font-size: 8pt;width: 15px"><?= $value['site']?></td>
        </tr>
        <tr>
          <th style="color:black;font-size: 8pt;width: 15px">E-mail</th>
          <td style="font-size: 8pt;width: 15px"><?= $value['email']?></td>
        </tr>
        <tr>
          <th style="color:black;font-size: 8pt;width: 15px"><?= t('Phone', 'company')?></th>
          <td style="font-size: 8pt;width: 15px"><?= $value['phone']?></td>
        </tr>


<?php endforeach; ?>
      <?php if($isComputed):  ?>
      <tr  style="color:black;font-size: 9pt;width: 15px">
          <td><?php echo t('Total','requests') ?>:</td>
          <td style="text-align: right"><?php echo number_format($price, 0, '.', ' ') . ' ' . $valute ?></td>
      </tr>
      <?php endif; ?>
