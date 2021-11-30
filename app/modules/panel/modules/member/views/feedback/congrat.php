<?php

use yii\helpers\Html;
    $this->title = Yii::t('app/menu','Feedback form');
?>

<div class="card col-12">
    <div class="card-body">
<div class="alert alert-success alert-dismissible">
    <?php echo t('The message has been sent'); ?>
</div>


<?= Html::a(Yii::t('app', 'Home'), ['/'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>


