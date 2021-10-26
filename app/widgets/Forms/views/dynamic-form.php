<?php

use app\core\manage\Auth\UserIdentity;
use app\widgets\Forms\assets\DynamicFormAsset;

/** @var UserIdentity $user */
/** @var bool $readOnly */

DynamicFormAsset::register($this);
?>
<div class="dynamic-form">
    <div id="dynamic-form-app" data-read_only="<?php echo $readOnly ?>">
    </div>
</div>