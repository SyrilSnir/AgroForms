<?php

$this->title = Yii::t('app','Free information');
?>
  <!-- Content Wrapper. Contains page content -->
<section class="content content-large main-section">  
    <!-- Content Header (Page header) -->
        <div class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
          <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $membersCount ?></h3>

                <p><?php echo \Yii::t('app', '{member, plural, =1{exhibition participant} other{exhibitions}}', ['member' => $membersCount]); ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-user-circle-o"></i>
              </div>
              <a href="manage/users/?UserSearch[user_type_id]=2" class="small-box-footer"><?php echo Yii::t('app', 'More info') ?> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>            
        </div>
       </div>
          </div>
</section>
