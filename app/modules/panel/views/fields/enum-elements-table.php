<?php 
use yii\helpers\Html;

/** @var array $enumsList */
?>
<div id="attributes-enum-list" class="card">
              <div class="card-header">
                <h3 class="card-title">Перечисляемые элементы</h3>
              </div>
              <!-- /.card-header -->              
              <div class="card-body">
                <table class="table table-bordered attributes-enum-table">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Название элемента</th>
                      <th>Название элемента (ENG)</th>
                      <th>Значение</th>
                      <th style="width: 10px"></th>
                    </tr>
                    </thead>                    
                  <tbody>                    
                    <?php $enumIndex = 1; ?>
                    <?php foreach ($enumsList as $enum): ?>
                      <tr data-number="<?php echo $enumIndex ?>">
                            <td><?php echo $enumIndex ?></td>
                            <td class="attribute-enum-name"><?php echo $enum['name'] ?></td>
                            <td class="attribute-enum-name"><?php echo $enum['name_eng'] ?></td>
                            <td class="attribute-enum-value"><?php echo $enum['value'] ?></td>
                            <td>    
                                <a class="btn btn-app delete-enum-field">
                                    <i class="fas fa-times"></i>Удалить
                                </a> 
                            </td>
                        </tr>
                        <?php $enumIndex++ ;?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                  <div class="container">
                      <div class="row align-items-end">
                          <div class="col-4">
                              <div class="field">Имя поля: </div>
                              <?php echo Html::input('text', 'enum-name', '', [
                                  'class' => 'form-control enum-field-name',
                              ]);?>
                          </div>
                          <div class="col-4">
                            <div class="field">Имя поля (eng): </div>
                              <?php echo Html::input('text', 'enum-name_eng', '', [
                                  'class' => 'form-control enum-field-name-eng',
                              ]);?>
                          </div>                            
                          <div class="col-4">
                            <div class="field">Значение: </div>
                              <?php echo Html::input('text', 'enum-name', '', [
                                  'class' => 'form-control enum-field-value',
                              ]);?>
                          </div>                        
                          <div class="col-3 align-items-end">
                              <button type="button" class="btn btn-block btn-success enum-field-add-button">Добавить</button>
                          </div>
                      </div>
                  </div> 
                  
              </div>
            </div>

