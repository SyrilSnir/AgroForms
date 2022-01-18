<?php

use app\core\manage\Auth\UserIdentity;
use app\models\ActiveRecord\Forms\Stand;
use app\widgets\Forms\assets\StandAsset;

/** @var UserIdentity $user */
/** @var Stand[] $standsList */


StandAsset::register($this);
?>
<div class="stand-form">
    <div id="stand-app" data-read_only="<?php echo $readOnly ?>">
        <template></template>
    </div>
</div>