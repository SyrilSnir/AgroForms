<?php 
    /** @var string $title */
    /** @var [] $values */
?>
<?php $index = 0; ?>
<?php foreach ($values as $value) :?>
<div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2"><?= $title . ' №' . ++$index ?></th>            
                            </tr>
                        </thead>                        
                      <tbody>
                      <tr>
                        <th style="width:50%"><?= t('Surname', 'user')?></th>
                        <td><?= $value['surName']?></td>
                      </tr>                          
                          <tr>
                        <th><?= t('Name', 'user')?></th>
                        <td><?= $value['name']?></td>
                      </tr>
                      <tr>
                        <th><?= t('Middle Name', 'user')?></th>
                        <td><?= $value['middleName']?></td>
                      </tr>
                      <tr>
                        <th><?= t('Company', 'user')?></th>
                        <td><?= $value['company']?></td>
                      </tr>                      
                    </tbody></table>
                  </div>
                </div>
<?php endforeach; ?>
      <?php if($isComputed):  ?>
<table class="table"><tbody>
      <tr style="font-weight: 600">
          <td><?php echo t('Total','requests') ?>:</td>
          <td style="text-align: right"><?php echo number_format($price, 0, '.', ' ') . ' ' . $valute ?></td>
      </tr></tbody></table>
      <?php endif; ?>
