<?php

use app\core\helpers\Menu\AccountantMenuHelper;
use app\core\helpers\Menu\AdminMenuHelper;
use app\core\helpers\Menu\ManagerMenuHelper;
use app\core\helpers\Menu\MemberMenuHelper;
use app\core\helpers\Menu\OrganizerMenuHelper;
use app\core\manage\Auth\Rbac;
use app\widgets\AdminLTE\Menu\MenuWidget;
/** @var string $directoryAsset */
?>
<aside class="main-sidebar sidebar-black-primary elevation-4">
        <!-- Brand Logo -->
    <a href="http://www.agrosalon.ru" class="brand-link">
      <img src="/build/images/agrosalon.png" alt="Agrosalon Logo" class="agrosalon-logo elevation-3">
      <img src="/build/images/as.png" alt="Agrosalon Logo" class="agrosalon-small-logo elevation-3">
    </a>
    <div class="sidebar">
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/build/images/thumbnail.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a id="dropdownMenuLink" href="#" class="d-block" data-toggle="dropdown"><?php echo Yii::$app->user->getIdentity()->login ?></a>
<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item user-dropdown" href="/logout"><i class="fa fa-sign-out mr-2"></i><?php echo t('Exit')?></a>
  </div>            
        </div>    


      </div>        
        <nav class="mt-2">
            <?php if (Yii::$app->user->can(Rbac::PERMISSION_ADMINISTRATOR_MENU)): ?>        
    <?php echo MenuWidget::widget(
            AdminMenuHelper::getMenu()
        ) ?>
    <?php elseif (Yii::$app->user->can(Rbac::PERMISSION_MEMBER_MENU)): ?>        
        <?php echo MenuWidget::widget(
             MemberMenuHelper::getMenu(['user' => Yii::$app->user->getIdentity()])
    ) ?>        
    <?php elseif (Yii::$app->user->can(Rbac::PERMISSION_MANAGER_MENU)): ?>
        <?php 
            echo MenuWidget::widget(ManagerMenuHelper::getMenu())
        ?>        
    <?php elseif (Yii::$app->user->can(Rbac::PERMISSION_ACCOUNTANT_MENU)): ?>
    <?php 
        echo MenuWidget::widget(AccountantMenuHelper::getMenu())
    ?>    
    <?php elseif (Yii::$app->user->can(Rbac::PERMISSION_ORGANIZER_MENU)): ?>
        <?php 
            echo MenuWidget::widget(OrganizerMenuHelper::getMenu())
        ?>
    <?php endif ;?>          
        </nav>
    </div>
</aside>
