<?php

use app\models\ActiveRecord\Companies\Company;
use yii\web\View;

/** @var array $summaryInformation */
/** @var View $this */
/** @var Company $company */
$this->title = Yii::t('app','Free information');
//dump($summaryInformation);
?>
  <!-- Content Wrapper. Contains page content -->
<section class="content content-large main-section">  
    <!-- Content Header (Page header) -->
    <div class="content">
        <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <?php if(count($summaryInformation['past']) > 0): ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?php echo t('Past exhibitions','exhibitions'); ?></h3>
                </div>
            <?php echo $this->render('blocks'. DIRECTORY_SEPARATOR . 'exhibitions',[
                'exhibitionList' => $summaryInformation['past'],
                'company' => $company
            ]); ?>
            </div>
        <?php endif; ?>
        <?php if(count($summaryInformation['active']) > 0): ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?php echo t('Current exhibitions','exhibitions'); ?></h3>
                </div>
            <?php echo $this->render('blocks'. DIRECTORY_SEPARATOR . 'exhibitions',[
                'exhibitionList' => $summaryInformation['active'],
                'company' => $company
            ]); ?>
            </div>
            <?php endif; ?>
            <?php if(count($summaryInformation['future']) > 0): ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?php echo t('Upcomming exhibitions','exhibitions'); ?></h3>
                </div>
            <?php echo $this->render('blocks'. DIRECTORY_SEPARATOR . 'exhibitions',[
                'exhibitionList' => $summaryInformation['future'],
                'company' => $company
            ]); ?>

            </div>        
        <?php endif; ?>
        </div>
    </div>
</section>

