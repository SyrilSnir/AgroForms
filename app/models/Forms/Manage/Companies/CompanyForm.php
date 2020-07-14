<?php

namespace app\models\Forms\Manage\Companies;

use app\models\ActiveRecord\Companies\Company;
use app\models\Forms\MultiForm;

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

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
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
          //  [['bank_details_id'], 'exist', 'skipOnError' => true, 'targetClass' => BankDetail::className(), 'targetAttribute' => ['bank_details_id' => 'id']],
        //    [['contacts_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contact::className(), 'targetAttribute' => ['contacts_id' => 'id']],
       //     [['legal_address_id'], 'exist', 'skipOnError' => true, 'targetClass' => LegalAddress::className(), 'targetAttribute' => ['legal_address_id' => 'id']],
       //     [['postal_address_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostalAddress::className(), 'targetAttribute' => ['postal_address_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'fullName' => 'Полное наименование',
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'phone' => 'Телефон',
            'site' => 'Сайт',
            'fax' => 'Факс',
            'contacts_id' => 'Контакты',
            'bank_details_id' => 'Банковские реквизиты',
            'postal_address_id' => 'Почтовый адрес',
            'legal_address_id' => 'Юридический адрес',
            'image_path' => 'Путь к файлу с изображением',
            'image_url' => 'Url файла с изображением',
            'deleted' => 'Deleted',
        ];
    }

    protected function internalForms(): array
    {
    return ['legalAddressForm','postalAddressForm','bankDetails','contacts'];
    }

}
