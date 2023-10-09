<?php 
    /** @var string $title */
?>
<?php $index = 0; ?>
<?php foreach ($values as $value) :?>
                    <tr>
                        <th style="color:black;font-size: 9pt;width: 15px" colspan="2"><?= $title . ' №' . ++$index ?></th>            
                    </tr>
                      <tr>
                        <th style="color:black;font-size: 8pt;width: 15px"><?= t('Country')?></th>
                        <td style="font-size: 8pt;width: 15px"><?= $value['country']?></td>
                      </tr>                          
                          <tr>
                        <th style="color:black;font-size: 8pt;width: 15px"><?= t('Region') ?></th>
                        <td style="font-size: 8pt;width: 15px"><?= $value['area']?></td>
                      </tr>
                      <tr>
                        <th style="color:black;font-size: 8pt;width: 15px"><?= t('City')?></th>
                        <td style="font-size: 8pt;width: 15px"><?= $value['city']?></td>
                      </tr>
                      <tr>
                        <th style="color:black;font-size: 8pt;width: 15px"><?= t('Address')?></th>
                        <td style="font-size: 8pt;width: 15px"><?= $value['address']?></td>
                      </tr>                      
                      <tr>
                        <th style="color:black;font-size: 8pt;width: 15px"><?= t('Zip code', 'company')?></th>
                        <td style="font-size: 8pt;width: 15px"><?= $value['index']?></td>
                      </tr>                       
<?php endforeach; ?>
      <?php if($isComputed):  ?>
      <tr  style="color:black;font-size: 9pt;width: 15px">
          <td><?php echo t('Total','requests') ?>:</td>
          <td style="text-align: right"><?php echo number_format($price, 0, '.', ' ') . ' ' . $valute ?></td>
      </tr>
      <?php endif; ?>
