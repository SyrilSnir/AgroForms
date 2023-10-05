<?php $index = 1; ?>
<?php foreach ($values as $value) :?>
<div class="col-6">
                  <p class="lead">#<?= $index++ ?></p>

                  <div class="table-responsive">
                    <table class="table">
                      <tbody><tr>
                        <th style="width:50%">Сайт</th>
                        <td><?= $value['site']?></td>
                      </tr>
                      <tr>
                        <th>Email</th>
                        <td><?= $value['email']?></td>
                      </tr>
                      <tr>
                        <th>Телефон</th>
                        <td><?= $value['phone']?></td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
<?php endforeach; ?>