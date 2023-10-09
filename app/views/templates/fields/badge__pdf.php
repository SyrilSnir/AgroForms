<?php $index = 0; ?>
                <?php foreach ($values as $value) :?>
                            <tr>
                                <th style="color:black;font-size: 9pt;width: 15px" colspan="2"><?= $title . ' №' . ++$index ?></th>            
                            </tr>
                        </thead>                        
                      <tbody>
                      <tr>
                        <th style="color:black;font-size: 8pt;width: 15px"><?= t('Surname', 'user')?></th>
                        <td style="font-size: 8pt;width: 15px"><?= $value['surName']?></td>
                      </tr>                          
                          <tr>
                        <th style="color:black;font-size: 8pt;width: 15px"><?= t('Name', 'user')?></th>
                        <td style="font-size: 8pt;width: 15px"><?= $value['name']?></td>
                      </tr>
                      <tr>
                        <th style="color:black;font-size: 8pt;width: 15px"><?= t('Middle Name', 'user')?></th>
                        <td style="font-size: 8pt;width: 15px"><?= $value['middleName']?></td>
                      </tr>
                      <tr>
                        <th style="color:black;font-size: 8pt;width: 15px"><?= t('Company', 'user')?></th>
                        <td style="font-size: 8pt;width: 35px"><?= $value['company']?></td>
                      </tr>                      
                <?php endforeach; ?>
      <?php if($isComputed):  ?>
      <tr  style="color:black;font-size: 9pt;width: 15px">
          <td><?php echo t('Total','requests') ?>:</td>
          <td style="text-align: right"><?php echo number_format($price, 0, '.', ' ') . ' ' . $valute ?></td>
      </tr>
      <?php endif; ?>