<?php

namespace app\models\Forms\Manage\Companies;

use app\models\ActiveRecord\Companies\Company;
use app\models\Forms\MultiForm;
use yii\web\UploadedFile;
use function t;

/**
 * Description of CompanyForm
 *
 * 
 * @property LegalAddressForm $legalAddressForm
 * @property PostalAddressForm $postalAddressForm
 * @property BankDetailForm $bankDetails
 * @property ContactForm $contacts
 * 
 * @author kotov
 */
class CompanyForm extends MultiForm
{
    
    const SCENARIO_PROFILE_UPDATE = 'profileUpdate';
    
    /** @var string */
    public $name;    
    /** @var string */
    public $fullName;
    /** @var string */    
    public $inn;
    /** @var string */    
    public $kpp;
    /** @var string */    
    public $phone;
    /** @var string */    
    public $fax;
    /** @var string */    
    public $site;      
    /** @var string */
    public $logoPreview;
     /** @var string */
    public $logoImageFile;
     
    public function setScenario($value) 
    {
        if ($value == self::SCENARIO_PROFILE_UPDATE) {
            $this->legalAddressForm->setScenario($value);
            $this->postalAddressForm->setScenario($value);
            $this->bankDetails->setScenario($value);
            $this->contacts->setScenario($value);
        }
      //  parent::setScenario($value);
    }
    
    public function scenarios():array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PROFILE_UPDATE] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }



    public function __construct(Company $model = null, $config = array())
    {
        if ($model) {
            $this->name = $model->name;
            $this->fullName = $model->full_name;
            $this->inn = $model->inn;
            $this->kpp = $model->kpp;
            $this->phone = $model->phone;
            $this->fax = $model->fax;
            $this->site = $model->site;
            if ($model->logo) {
                $this->logoPreview = $model->getThumbFileUrl('logo');
            }
            $this->legalAddressForm = new LegalAddressForm($model->legalAddress);
            $this->postalAddressForm = new PostalAddressForm($model->postalAddress);
            $this->bankDetails = new BankDetailForm($model->bankDetails);
            $this->contacts = new ContactForm($model->contacts);
            
        } else {
            $this->legalAddressForm = new LegalAddressForm();
            $this->postalAddressForm = new PostalAddressForm();
            $this->bankDetails = new BankDetailForm();
            $this->contacts = new ContactForm();
        }
        
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'fullName', 'inn', 'phone'], 'required'],
            [['name', 'fullName', 'inn', 'kpp', 'phone','fax' ,'site'], 'string', 'max' => 255],
            [['logoImageFile'], 'image'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => t('Name','company'),
            'fullName' => t('Full name','company'),
            'inn' => t('INN','company'),
            'kpp' => t('KPP','company'),
            'phone' => t('Phone','company'),
            'site' => t('Site','company'),
            'fax' => t('Fax','company'),
            'logoImageFile' => t('Company`s logo','company')
        ];
    }
    
    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->logoImageFile = UploadedFile::getInstance($this, 'logoImageFile');
            return true;
        }
        return false;
    }    

    protected function internalForms(): array
    {
        return ['legalAddressForm','postalAddressForm','bankDetails','contacts'];
    }

}
