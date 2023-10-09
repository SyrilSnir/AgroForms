<?php $index = 1; ?>
<?php foreach ($values as $value) :?>
<div class="col-6">
                  <p class="lead">#<?= $index++ ?></p>

                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th style="width:50%">Страна</th>
                        <td><?= $value['country']?></td>
                      </tr>                          
                          <tr>
                        <th>Область</th>
                        <td><?= $value['area']?></td>
                      </tr>
                      <tr>
                        <th>Город</th>
                        <td><?= $value['city']?></td>
                      </tr>
                      <tr>
                        <th>Ардес</th>
                        <td><?= $value['address']?></td>
                      </tr>                      
                      <tr>
                        <th>Индекс</th>
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

