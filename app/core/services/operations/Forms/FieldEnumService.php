<?php

namespace app\core\services\operations\Forms;

use app\models\ActiveRecord\Forms\FieldEnum;

/**
 * Description of FieldEnumService
 *
 * @author kotov
 */
class FieldEnumService
{
    public function clearForField(int $fieldId)
    {
        FieldEnum::deleteAll([
            'field_id' => $fieldId
        ]);
    }
}
