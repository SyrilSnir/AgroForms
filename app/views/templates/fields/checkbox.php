<?php

use app\core\helpers\View\Form\FormElements\ElementCheckbox;
/** @var string $fieldName */
/** @var string $comment */
/** @var bool $hasComment */
/** @var [] $valuesList */
/** @var ElementCheckbox $checkbox */

?>

<div class="input__field"><div class="field__name"><?= $fieldName ?></div>
<?php  if (key_exists('value', $valuesList) && $valuesList['value'] > 0) : ?>
    <div class="field__value form-control"><?= $checkbox->modifyPrice($valuesList['value']).' '. $valute ?></div>
<?php endif;?>   

</div>
    <?php if ($hasComment):?>
<div class="card" style="margin-top: 10px">
              <div class="card-header">
                <h4 class="card-title"><b>
                      <?= t('Comment') ?></b>
                </h4>
              </div>
              <!-- /.card-header -->
              <div class="card-body clearfix">
                        <?= $comment ?>
              </div>
              <!-- /.card-body -->
            </div>
    <?php endif; ?>
