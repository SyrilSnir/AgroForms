<?php

use app\core\manage\Auth\UserIdentity;
use app\models\ActiveRecord\Forms\Stand;
use app\widgets\Forms\assets\StandAsset;

/** @var UserIdentity $user */
/** @var Stand[] $standsList */


StandAsset::register($this);
?>
<div id="stand-app">
    <template></template>
</div>