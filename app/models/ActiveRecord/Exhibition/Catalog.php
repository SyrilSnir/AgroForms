<?php

namespace app\models\ActiveRecord\Exhibition;

use app\core\traits\ActiveRecord\MultilangTrait;
use app\models\ActiveRecord\Geography\Country;
use app\models\ActiveRecord\Nomenclature\Rubricator;
use app\models\ActiveRecord\Requests\Request;
use app\models\Forms\Manage\Exhibition\CatalogForm;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
 * @property Country[] $countries
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
    
    /**
     * 
     * @var array
     */
    private $countries = [];
    
    /**
     * 
     * @var array
     */
    private $rubrics = [];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catalog';
    }
    
    public static function create(CatalogForm $form): self
    {
        $model = new self();
        $model->exhibition_id = $form->exhibitionId;
        $model->request_id = $form->requestId;
        $model->company = $form->company;
        $model->company_eng = $form->companyEng;
        $model->description = $form->description;
        $model->description_eng = $form->descriptionEng;
        $model->_oldFilePath = $form->logoFile;        
        $model->logo_file = basename($form->logoFile);
        $model->countries = array_unique(ArrayHelper::merge($form->country, $form->countryEng));
        $model->rubrics = $form->rubricatorIds;
        $model->stand = $form->stand;
        return $model;
    }
    
    public function edit(CatalogForm $form): void
    {        
        $this->exhibition_id = $form->exhibitionId;
        $this->request_id = $form->requestId;
        $this->company = $form->company;
        $this->company_eng = $form->companyEng;
        $this->description = $form->description;
        $this->description_eng = $form->descriptionEng;
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
        if (!empty($this->countries)) {
            foreach ($this->countries as $countryId) {
               $model = CatalogCountries::create($this->id, $countryId);
               $model->save();
            }
        }
        if (!empty($this->rubrics)) {
            foreach ($this->rubrics as $rubricId) {
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
    
    public function getCountries()
    {
        $junctionTableName = CatalogCountries::tableName();
        return $this->hasMany(Country::class, ['id' => 'country_id'])
                ->viaTable($junctionTableName, ['catalog_id' => 'id']);
    }
    
    public function getContacts()
    {
        return $this->hasMany(CatalogContacts::class, ['catalog_id' => 'id']);
    }
}
