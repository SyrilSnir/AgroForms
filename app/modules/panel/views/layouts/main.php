<?php

use app\assets\ManageAsset;
use app\modules\panel\assets\AdminLteAsset;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $content string */

ManageAsset::register($this);
AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>

<?php
if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );    
} else {
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    $this->beginPage();    
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $this->title ?></title>
<?php echo Html::csrfMetaTags() ?>
<?php $this->head() ?>
<script src="https://kit.fontawesome.com/0846706cff.js" crossorigin="anonymous"></script>
<body class="hold-transition sidebar-mini layout-fixed agro-template layout-navbar-fixed layout-footer-fixed agro">
<?php $this->beginBody() ?>
<div class="wrapper">
<?php 
    echo $this->render('_header.php',['directoryAsset' => $directoryAsset]);
    echo $this->render('_left.php',['directoryAsset' => $directoryAsset]);
    echo $this->render('_content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        );
    
?>    
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
        
<?php } ?>
