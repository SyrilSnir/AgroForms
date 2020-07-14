<?php

use app\core\manage\Auth\UserIdentity;
use app\widgets\Forms\assets\DynamicFormAsset;

/** @var UserIdentity $user */


DynamicFormAsset::register($this);
?>
<div class="dynamic-form">
    <div id="dynamic-form-app">
    </div>
</div>