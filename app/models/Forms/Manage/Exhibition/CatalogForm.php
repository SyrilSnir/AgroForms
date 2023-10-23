<?php

namespace app\models\Forms\Manage\Exhibition;

use app\models\ActiveRecord\Exhibition\Catalog;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\Forms\Manage\ManageForm;

/**
 * Description of CatalogForm
 *
 * @author kotov
 */
class CatalogForm extends ManageForm
{
    public $requestId;
    public $exhibitionId;
    public $description;
    public $descriptionEng;
    public $company;
    public $companyEng;
    public $logoFile;
    public $country;
    public $countryEng;
    public $rubricatorIds;
    public $stand;


    public function __construct(Catalog $model = null, $config = [])
    {
        if ($model) {
            $this->company = $model->company;
            $this->companyEng = $model->company_eng;
            $this->description = $model->description;
            $this->descriptionEng = $model->description_eng;
            $this->exhibitionId = $model->exhibition_id;
            $this->requestId = $model->request_id;
            
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exhibitionId','requestId'], 'required'],
            [['exhibitionId','requestId'], 'integer'],
            [['description', 'descriptionEng','stand'], 'string'],
            [['rubricatorIds', 'country', 'countryEng'], 'default', 'value' => []],
            [['rubricatorIds', 'country', 'countryEng'], 'each', 'rule' => ['integer']],            
            [['logoFile', 'company', 'companyEng'], 'string', 'max' => 255],
            [['exhibitionId'], 'exist', 'skipOnError' => true, 'targetClass' => Exhibition::class, 'targetAttribute' => ['exhibitionId' => 'id']],
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
