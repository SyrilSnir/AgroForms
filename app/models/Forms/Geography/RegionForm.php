<?php

namespace app\models\Forms\Geography;

use app\core\traits\Lists\GetCountriesTrait;
use app\models\ActiveRecord\Geography\Country;
use app\models\ActiveRecord\Geography\Region;
use yii\base\Model;

/**
 * Description of RegionForm
 *
 * @author kotov
 */
class RegionForm extends Model
{
    public $name;
    public $country;
    
    use GetCountriesTrait;  
    
    public function __construct(Region $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->country = $model->country_id;
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'country'], 'required'],
            [['country'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название региона',
            'country' => 'Страна',
        ];
    }    
    
}
