<?php

use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Requests\Request;

/** @var Form $form */
/** @var string $elements */
/** @var Request $request */
/** @var Application $application */

$application = $request->getRequestForm();
?>
<div class="request__view">
    <div class="card card-primary">
        <div class="card-header">
            <?php echo $form->headerName ?>
        </div>
        <div class="card-body">
            <?php echo $elements ?>
            <?php if($attachedFile):?>
            <div>
                <h5 style="margin-top:20px">Прикрепленный файл:</h5>
                <i class="fa fa-file" aria-hidden="true"></i>
                <a href="<?php echo $attachedFile ?>"><?php echo $attachedFile ?></a>
            </div>
            <?php endif;?>
            <div class="input__field total">
                <div class="field__name">
                    <?php echo t('Total amount payable','requests')?>:
                </div>

                <div class="field__value form-control">
                    <?php echo $amount . ' ' . $form->valute->symbol ?>
                </div>
            </div>
        </div>
    </div>
</div>
