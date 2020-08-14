<?php

namespace app\models\ActiveRecord\Forms;

use app\core\traits\ActiveRecord\MultilangTrait;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%form_types}}".
 *
 * @property int $id
 * @property string|null $name Название
 * @property string|null $description Описание
 * @property string|null $name_eng Название (ENG)
 * @property string|null $description_eng Описание (ENG)
 */
class FormType extends ActiveRecord
{
    /**
     * Стандартный стенд
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
    
    use MultilangTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%form_types}}';
    }

    public static function create(
            $name, 
            $description,
            $nameEng = '', 
            $descriptionEng = ''
            ):self
    {
        $formType = new FormType();
        $formType->name = $name;
        $formType->description = $description;
        $formType->name_eng = $nameEng;
        $formType->description_eng = $descriptionEng;
        return $formType;
    }
    
    public function edit(
            $name, 
            $description,
            $nameEng = '', 
            $descriptionEng = ''            
            )
    {
        $this->name = $name;
        $this->description = $description;
        $this->name_eng = $nameEng;
        $this->description_eng = $descriptionEng;
    }
}
