<?php

namespace app\core\providers\Data;

use app\models\ActiveRecord\Forms\Field;
use app\models\ActiveRecord\Forms\FieldEnum;

/**
 * Description of FieldEnumProvider
 *
 * @author kotov
 */
class FieldEnumProvider
{
    public function getEnumsList(Field $field):array
    {
        if (!$field->hasEnums()) {
            return [];
        }
        $enumsList = $field->enums;
        $enumsArray = [];
        /** @var FieldEnum $enum */
        foreach ($enumsList as $enum)
        {
            $enumsArray[] = [
                'name' => $enum->name,
                'value' => $enum->value
            ];
        }
        return $enumsArray;
    }
}
