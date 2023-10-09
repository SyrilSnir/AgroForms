<?php 
    /** @var string $title */
?>
<?php $index = 1; ?>
<?php foreach ($values as $value) :?>
<div class="col-6">
                  <p class="lead">#<?= $index++ ?></p>

                  <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2"><?= $title ?></th>            
                            </tr>
                        </thead>                         
                      <tbody>
                      <tr>
                        <th style="width:50%"><?= t('Country')?></th>
                        <td><?= $value['country']?></td>
                      </tr>                          
                          <tr>
                        <th><?= t('Region') ?></th>
                        <td><?= $value['area']?></td>
                      </tr>
                      <tr>
                        <th><?= t('City')?></th>
                        <td><?= $value['city']?></td>
                      </tr>
                      <tr>
                        <th><?= t('Address')?></th>
                        <td><?= $value['address']?></td>
                      </tr>                      
                      <tr>
                        <th><?= t('Zip code', 'company')?></th>
                        <td><?= $value['index']?></td>
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

