<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPTrait.php to edit this template
 */

namespace app\core\traits\Lists;

use app\models\ActiveRecord\Users\ManagerRoles;
use yii\helpers\ArrayHelper;

/**
 *
 * @author kotov
 */
trait GetManagerRolesTrait
{
    public function rolesList(): array
    {
        return ArrayHelper::map(ManagerRoles::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }
}
