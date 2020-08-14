      <!-- Navbar -->
<?php 

    use lajax\languagepicker\widgets\LanguagePicker;
?>

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
          <a href="/" class="nav-link"><?php echo t('Main page');?></a>
      </li>
    </ul>
    <?php if (Yii::$app->user->can(app\core\manage\Auth\Rbac::PERMISSION_MEMBER_MENU)): ?>
<?= LanguagePicker::widget([
    'skin' => LanguagePicker::SKIN_BUTTON,
    'size' => LanguagePicker::SIZE_SMALL
]); ?>
  <?php endif ;?>
  </nav>

