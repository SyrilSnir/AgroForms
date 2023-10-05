<?php $index = 1; ?>
<?php foreach ($values as $value) :?>
<div class="col-6">
                  <p class="lead">#<?= $index++ ?></p>

                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th style="width:50%">Фамилия</th>
                        <td><?= $value['surName']?></td>
                      </tr>                          
                          <tr>
                        <th>Имя</th>
                        <td><?= $value['name']?></td>
                      </tr>
                      <tr>
                        <th>Отчество</th>
                        <td><?= $value['middleName']?></td>
                      </tr>
                      <tr>
                        <th>Компания</th>
                        <td><?= $value['company']?></td>
                      </tr>                      
                    </tbody></table>
                  </div>
                </div>
<?php endforeach; ?>
