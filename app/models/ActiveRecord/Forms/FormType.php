<?php

namespace app\models\ActiveRecord\Forms;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%form_types}}".
 *
 * @property int $id
 * @property string|null $name Название
 * @property string|null $description Описание
 */
class FormType extends ActiveRecord
{
    /**
     * Cnfylfhnysq cntyl
     */
    const SPECIAL_STAND_FORM = 1;
    /**
     * Технические плдключения
     */
    const SPECIAL_CONNECTION_FORM = 2;
    const DYNAMIC_INFORMATION_FORM = 10;
    const DYNAMIC_ORDER_FORM = 11;
    
    const HAS_DYNAMIC_FIELDS = [
        self::DYNAMIC_INFORMATION_FORM,
        self::DYNAMIC_ORDER_FORM
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%form_types}}';
    }

    public static function create($name, $description):self
    {
        $formType = new FormType();
        $formType->name = $name;
        $formType->description = $description;
        return $formType;
    }
    
    public function edit($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }
}
