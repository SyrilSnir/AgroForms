<?php

namespace app\models\Forms\Geography;

use app\core\traits\Lists\GetCountriesTrait;
use app\core\traits\Lists\GetRegionsTrait;
use app\models\ActiveRecord\Geography\City;
use yii\base\Model;

/**
 * Description of CityForm
 *
 * @author kotov
 */
class CityForm extends Model
{
    public $name;
    public $region;
    public $countryId;

    use GetCountriesTrait;
    use GetRegionsTrait;
    
    public function __construct(City $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->region = $model->region_id;
            $this->countryId = $model->country->id;
        }
        parent::__construct($config);
    }
    
    public function rules(): array
    {
        return [
            [['name', 'region','countryId'], 'required'],
            [['region','countryId'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название города',
            'region' => 'Регион',
            'countryId' => 'Страна',
        ];
    }
}
