<?php

use app\core\manage\Auth\UserIdentity;
use app\widgets\Forms\assets\DynamicFormAsset;

/** @var UserIdentity $user */
/** @var bool $readOnly */
/** @var int $contractId */

DynamicFormAsset::register($this);
?>
<div class="dynamic-form">
    <div 
        id="dynamic-form-app" 
        data-read-only="<?php echo $readOnly ?>"
        data-contract-id="<?php echo $contractId ?>"
        >
    </div>
</div>