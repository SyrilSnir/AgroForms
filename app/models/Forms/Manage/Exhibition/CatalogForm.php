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
    public $country;
    public $countryEng;
    public $logoFile;
    public $rubricatorIds;
    public $stand;
    /**
     * 
     * @var CatalogContactsForm[]
     */
    public $contactForms = [];


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
    
    public function setAttributes($values, $safeOnly = true)
    {
        if (key_exists('contacts', $values) && !empty($values['contacts'])) {
            foreach ($values['contacts'] as $contact) {
                $contactForm = new CatalogContactsForm();
                $contactForm->setAttributes($contact);
                if ($contactForm->validate()) {
                    $this->contactForms[] = $contactForm;
                }
            }
        }
        parent::setAttributes($values, $safeOnly);
    }
}
