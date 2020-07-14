<?php

namespace app\models\Forms\Geography;

use app\models\ActiveRecord\Geography\Country;
use yii\base\Model;

/**
 * Description of CountryForm
 *
 * @author kotov
 */
class CountryForm extends Model
{
    public $name;
    public $code;
    
    public function __construct(Country $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->code = $model->code;
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название страны',
            'code' => 'Трехбуквенный код страны',
        ];
    }
}
