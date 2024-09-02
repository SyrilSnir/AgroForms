<?php

namespace app\models\ActiveRecord\Exhibition;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\ActiveRecord\Geography\Country;
use app\models\ActiveRecord\Nomenclature\Rubricator;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\CatalogAddressForm;
use app\models\Forms\Manage\Exhibition\CatalogForm;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "catalog".
 *
 * @property int $id
 * @property int $request_id Номер заявки
 * @property int $exhibition_id Выставка
 * @property string|null $logo_file Файл логотипа
 * @property string|null $company Компания
 * @property string|null $company_eng Компания (ENG)
 * @property string|null $description Описание
 * @property string|null $description_eng Описание (ENG)
 * @property string|null $stand Номер стенда
 *
 * @property CatalogRubrics[] $catalogRubrics
 * @property Exhibition $exhibition
 * @property Request $request
 * @property Rubricator[] $rubrics
 * @property CatalogContacts[] $contacts
 * @property CatalogAddresses[] $addresses
 * 
 */
class Catalog extends ActiveRecord
{
    use MultilangTrait;
    
    /**
     * 
     * @var string
     */
    private $_oldFilePath = '';
    
    private $addressList = [];
    
    private $rubricsList = [];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%catalog}}';
    }
    
    public static function create(CatalogForm $form): self
    {
        $model = new self();
        $model->exhibition_id = $form->exhibitionId;
        $model->request_id = $form->requestId;
        $model->company = trim($form->company);
        $model->company_eng = trim($form->companyEng);
        $model->description = trim($form->description);
        $model->description_eng = trim($form->descriptionEng);
        $model->_oldFilePath = trim($form->logoFile);
        $model->logo_file = basename($model->_oldFilePath);
        $model->addressList = $model->getAddressData($form->country, $form->countryEng);
        $model->rubricsList = $form->rubricatorIds;
        $model->stand = $form->stand;
        return $model;
    }
    
    public function edit(CatalogForm $form): void
    {        
        $this->exhibition_id = $form->exhibitionId;
        $this->request_id = $form->requestId;
        $this->company = trim($form->company);
        $this->company_eng = trim($form->companyEng);
        $this->description = trim($form->description);
        $this->description_eng = trim($form->descriptionEng);
        $this->country = $form->country;
        $this->country_eng = $form->countryEng;
        $this->stand = $form->stand;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'exhibition_id' => 'Exhibition ID',
            'logo_file' => 'Logo File',
            'company' => 'Company',
            'company_eng' => 'Company Eng',
            'country' => 'Country',
            'country_eng' => 'Country Eng',
            'description' => 'Description',
            'description_eng' => 'Description Eng',
        ];
    }

    /**
     * Gets query for [[CatalogRubrics]].
     *
     * @return ActiveQuery
     */
    public function getCatalogRubrics()
    {
        return $this->hasMany(CatalogRubrics::class, ['catalog_id' => 'id']);
    }

    /**
     * Gets query for [[Exhibition]].
     *
     * @return ActiveQuery
     */
    public function getExhibition()
    {
        return $this->hasOne(Exhibition::class, ['id' => 'exhibition_id']);
    }
    
    /**
     * Gets query for [[Request]].
     *
     * @return ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::class, ['id' => 'request_id']);
    }    

    /**
     * Gets query for [[Rubrics]].
     *
     * @return ActiveQuery
     */
    public function getRubrics()
    {
        $junctionTableName = CatalogRubrics::tableName();        
        return $this->hasMany(Rubricator::class, ['id' => 'rubric_id'])
                ->viaTable($junctionTableName, ['catalog_id' => 'id']);
    }

 
    /**
     * Gets query for [[Rubrics]].
     *
     * @return ActiveQuery
     */
    public function getCountries()
    {
        $junctionTableName = CatalogAddresses::tableName();        
        return $this->hasMany(Country::class, ['id' => 'country_id'])
                ->viaTable($junctionTableName, ['catalog_id' => 'id']);
    }

    
    public function beforeDelete()
    {
        $logoPath = $this->getLogoPath();
        if (file_exists($logoPath)) {
            unlink($logoPath);
        }
        return parent::beforeDelete();
    }


    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $this->_actionsAfterInsert();
        }
        parent::afterSave($insert, $changedAttributes);
    }
    
    public function getLogoUrl(): string
    {
        return Yii::getAlias('@catalogUrl') . '/' .$this->id 
                . '/' . $this->logo_file;
    }
    
    public function getLogoPath(): string
    {
        return Yii::getAlias('@catalogPath') . DIRECTORY_SEPARATOR .$this->id . 
                DIRECTORY_SEPARATOR . $this->logo_file;
    }    


    public function _actionsAfterInsert() 
    {        
        if (!empty($this->addressList)) {
            foreach ($this->addressList as $countryId => $el) {
               $form = new CatalogAddressForm();
               $form->setAttributes($el);
               $model = CatalogAddresses::create($this->id, $countryId,$form);
               $model->save();
            }
        }
        if (!empty($this->rubricsList)) {
            foreach ($this->rubricsList as $rubricId) {
                $model = CatalogRubrics::create($this->id, $rubricId);
                $model->save();
            }
        }
        $catalogPath = Yii::getAlias('@catalogPath');
        if (!is_dir($catalogPath)) {
            mkdir($catalogPath);
        }
        if(file_exists($this->_oldFilePath)) {
            $destinationDir = $catalogPath . DIRECTORY_SEPARATOR . $this->id ;
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir);
            }
            copy($this->_oldFilePath, $destinationDir . DIRECTORY_SEPARATOR . $this->logo_file);
        }
    }
    
    public function getAddresses()
    {
        return $this->hasMany(CatalogAddresses::class, ['catalog_id' => 'id']);                
    }
    
    public function getCountryNames() :string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, $address->country->name);
        }
        return implode(',', $cList);
    }
    
    public function getCountryNamesEng() : string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, $address->country->name_eng);
        }
        return implode(',', $cList);        
    }
    
    public function getRegionNames() :string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, $address->region);
        }
        return implode(',', $cList);
    }
    
    public function getRegionNamesEng() : string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, $address->region_eng);
        }
        return implode(',', $cList);        
    }
    
    public function getCityNames() :string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, $address->city);
        }
        return implode(',', $cList);
    }
    
    public function getCityNamesEng() : string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, $address->city_eng);
        }
        return implode(',', $cList);        
    }
    
    public function getIndexes() :string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, $address->index);
        }
        return implode(',', $cList);
    }
    
    public function getZipCodes() : string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, $address->zip_code);
        }
        return implode(',', $cList);        
    }
    
    public function getAddressText() : string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, $address->address);
        }
        return implode(',', $cList);        
    }
    public function getAddressTextEng() : string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, $address->address_eng);
        }
        return implode(',', $cList);        
    }
    
    public function getFullAddressText() : string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, "{$address->country->name}, $address->index, $address->region,$address->city, $address->address");
        }
        return implode('; ', $cList);        
    }
    public function getFullAddressTextEng() : string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, "{$address->country->name_eng}, $address->zip_code, $address->region_eng,$address->city_eng, $address->address_eng");
        }
        return implode(',', $cList);        
    }
    
    public function getFullAddressWithoutCountry() : string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, "$address->index, $address->region,$address->city, $address->address");
        }
        return implode('; ', $cList);        
    }
    public function getFullAddressWithoutCountryEng() : string 
    {
        $cList = [];
        foreach ($this->addresses as $address) {
            array_push($cList, "$address->zip_code, $address->region_eng,$address->city_eng, $address->address_eng");
        }
        return implode(',', $cList);        
    }
    
    public function getPhones() : string 
    {
        $cList = [];
        foreach ($this->contacts as $contact) {
            array_push($cList, $contact->phone);
        }
        return implode(',', $cList);        
    }
    
    public function getEmails() : string 
    {
        $cList = [];
        foreach ($this->contacts as $contact) {
            array_push($cList, $contact->email);
        }
        return implode(',', $cList);        
    }
    
    public function getSites() : string 
    {
        $cList = [];
        foreach ($this->contacts as $contact) {
            array_push($cList, $contact->site);
        }
        return implode(',', $cList);        
    }
    
    public function getCategories() : string 
    {
        $cList = [];
        foreach ($this->rubrics as $rubric) {
            array_push($cList, $rubric->getOrderedName());
        }
        return implode(',', $cList);        
    }
    
    public function getCategoriesEng() : string 
    {
        $cList = [];
        foreach ($this->rubrics as $rubric) {
            array_push($cList, $rubric->getOrderedNameEng());
        }
        return implode(',', $cList);        
    }
    
    public function getParentCategories() : string 
    {
        $cList = [];
        foreach ($this->rubrics as $rubric) {
            array_push($cList, $rubric->parent->getOrderedName());
        }
        return implode(',', $cList);        
    }
    
    public function getParentCategoriesEng() : string 
    {
        $cList = [];
        foreach ($this->rubrics as $rubric) {
            array_push($cList, $rubric->parent->getOrderedNameEng());
        }
        return implode(',', $cList);        
    }
    
    private function getAddressData(array $cntRus, array $cntEng = []):array
    {
        foreach ($cntEng as $key => $value) {
            if (!key_exists($key, $cntRus)) {
                $cntRus[$key] = [
                    'country' => $key,
                    'area' => '',
                    'city' => '',
                    'index' => '',
                    'address' => ''
                ];
            }
        }
        foreach ($cntRus as $key => $value) {
            if (!key_exists($key, $cntEng)) {
                $cntRus[$key]['area_eng'] = '';
                $cntRus[$key]['city_eng'] = '';
                $cntRus[$key]['zip_code'] = '';
                $cntRus[$key]['address_eng'] = '';            
            } else {
                $cntRus[$key]['area_eng'] =  $cntEng[$key]['area'];
                $cntRus[$key]['city_eng'] = $cntEng[$key]['city'];
                $cntRus[$key]['zip_code'] = $cntEng[$key]['index'];
                $cntRus[$key]['address_eng'] = $cntEng[$key]['address'];                
            }
        }
        return $cntRus;
    }
    
    public function getContacts()
    {
        return $this->hasMany(CatalogContacts::class, ['catalog_id' => 'id']);
    }
}
