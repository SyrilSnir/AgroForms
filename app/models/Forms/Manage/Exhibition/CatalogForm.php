<?php

namespace app\models\Forms\Manage\Exhibition;

use app\models\ActiveRecord\Exhibition\Catalog;
use app\models\ActiveRecord\Exhibition\Exhibition;
use yii\base\Model;

/**
 * Description of CatalogForm
 *
 * @author kotov
 */
class CatalogForm extends Model
{
    public $exhibitionId;
    public $description;
    public $descriptionEng;
    public $company;
    public $companyEng;
    public $logoFile;
    public $country;
    public $countryEng;
    
    public function __construct(Catalog $model, $config = [])
    {
        if ($model) {
            $this->company = $model->company;
            $this->companyEng = $model->company_eng;
            $this->description = $model->description;
            $this->descriptionEng = $model->description_eng;
            $this->country = $model->country;
            $this->countryEng = $model->country_eng;
            $this->exhibitionId = $model->exhibition_id;
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exhibition_id'], 'integer'],
            [['description', 'description_eng'], 'string'],
            [['logo_file', 'company', 'company_eng', 'country', 'country_eng'], 'string', 'max' => 255],
            [['exhibition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exhibition::class, 'targetAttribute' => ['exhibition_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
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
}
