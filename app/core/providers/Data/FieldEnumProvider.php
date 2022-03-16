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
                'id' => $enum->id,
                'name' => $enum->name,
                'value' => $enum->value,
                'name_eng' => $enum->name_eng
                    
            ];
        }
        return $enumsArray;
    }
}
