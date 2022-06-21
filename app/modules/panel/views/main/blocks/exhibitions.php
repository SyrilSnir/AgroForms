<?php

use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Contract\Contracts;
use app\models\ActiveRecord\Document\Documents;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\ActiveRecord\Requests\Request;

/** @var array $exhibitionList */
/** @var Exhibition $exhibition */
/** @var Company $company */

?>
<div class="card-body">
    <?php foreach ($exhibitionList as $exhibition) :?>
        <?php 
            $contract = Contracts::find()->forExhibition($exhibition->id)->forCompany($company->id)->one();
            $applicationsCount = Request::find()->forExhibition($exhibition->id)->forCompany($company->id)->count();
            $documentsCount = Documents::find()->forExhibition($exhibition->id)->forCompany($company->id)->count();
        ?>
    <div class="card">
        <div class="card-header"><h4 class="card-title"><?php echo $exhibition->title ?></h4></div>  
        <div class="card-body">            
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $applicationsCount ?></h3>
                            <p><?php echo Yii::t('app', '{count, plural, =1{application created} other{applications created}}', ['count' => $applicationsCount]); ?></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check-square"></i>
                        </div>  
                        <a href="<?php echo "/panel/member/$exhibition->id/requests/$contract->id" ?>" class="small-box-footer"><?php echo Yii::t('app', 'More info') ?> <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">              
                  <div class="small-box bg-success">   
                        <div class="inner">
                            <h3><?php echo $documentsCount ?></h3>
                            <p><?php echo Yii::t('app', '{count, plural, =1{document created} other{documents created}}', ['count' => $documentsCount]); ?></p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file"></i>
                        </div>  
                        <a href="<?php echo "/panel/member/$exhibition->id/documents" ?>" class="small-box-footer"><?php echo Yii::t('app', 'More info') ?> <i class="fas fa-arrow-circle-right"></i></a>                      
                  </div>            
                </div>                       
            </div> 
        </div>  
    </div>
    <?php endforeach; ?>
</div>

