<?php

namespace app\models\Forms\Manage\Companies;

use app\core\repositories\readModels\Geography\CityReadRepository;
use app\core\traits\Lists\GetCitiesTrait;
use app\core\traits\Lists\GetCountriesTrait;
use app\core\traits\Lists\GetRegionsTrait;
use app\models\ActiveRecord\Companies\Address;
use app\models\ActiveRecord\Geography\City;
use yii\base\Model;

/**
 * Description of AddressForm
 *
 * @author kotov
 */
abstract class AddressForm extends Model
{
    const SCENARIO_PROFILE_UPDATE = 'profileUpdate';
    
    public $id;
    /** @var string Почтовый индекс */    
    public $index;
    
    /** @var int Страна */
    public $countryId;

    /** @var int Регион */
    public $regionId;

    /** @var int Город */
    public $cityId;
    
    public $address;

    use GetCountriesTrait;
    use GetRegionsTrait;
    use GetCitiesTrait;   
    
    public function __construct(Address $model = null,$config = array())
    {
        if ($model) {
            $this->index = $model->index;
            $this->countryId = $model->country->id;
            $this->regionId = $model->region->id;
            $this->cityId = $model->city_id;
            $this->address = $model->adds;    
            $this->id = $model->id;
        } else {
            /** @var City $city */
            $city = CityReadRepository::findById(City::MOSCOW);
            if ($city) {
                $this->cityId = $city->id;
                $this->regionId = $city->region->id;
                $this->countryId = $city->region->country_id;
            }
        }
        parent::__construct($config);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['index', 'cityId','id'], 'integer'],
            [['cityId', 'address'], 'required'],
            [['address'], 'string', 'max' => 255],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'index' => t('Zip code','company'),
            'cityId' => t('City'),
            'countryId' => t('Country'),
            'regionId' => t('Region'),
            'address' => t('Residence','company'),
        ];
    } 
    
    public function scenarios():array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PROFILE_UPDATE] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }    
}
