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
