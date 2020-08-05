<?php

namespace app\models\Forms\Manage\Companies;

use app\models\ActiveRecord\Companies\Contact;
use yii\base\Model;

/**
 * Description of ContactForm
 *
 * @author kotov
 */
class ContactForm extends Model
{
    const SCENARIO_PROFILE_UPDATE = 'profileUpdate';
    
    /** @var int */    
    public $id;    
    /** @var string */       
    public $chiefPosition;
    /** @var string */       
    public $chiefFio;
    /** @var string */       
    public $chiefPhone;
    /** @var string */       
    public $chiefEmail;
    /** @var string */       
    public $managerPosition;
    /** @var string */       
    public $managerFio;
    /** @var string */       
    public $managerPhone;
    /** @var string */       
    public $managerEmail;
    /** @var string */       
    public $managerFax;
    /** @var string */     
     public $proposalSignaturePost;
    /** @var string */              
     public $proposalSignatureName;   
    
    public function __construct(Contact $model = null, $config = array())
    {
        if ($model) {
            $this->chiefEmail = $model->chief_email;
            $this->chiefFio = $model->chief_fio;
            $this->chiefPosition = $model->chief_position;
            $this->chiefPhone = $model->chief_phone;  
            
            $this->managerEmail = $model->manager_email;
            $this->managerFax = $model->manager_fax;
            $this->managerFio = $model->manager_fio;
            $this->managerPhone = $model->manager_phone;                        
            $this->managerPosition = $model->manager_position;
            
            $this->proposalSignatureName = $model->proposal_signature_name;
            $this->proposalSignaturePost = $model->proposal_signature_post;
            
            $this->id = $model->id;
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
                   [['managerEmail'], 'required'],
                   [['proposalSignatureName','proposalSignaturePost'],'required', 'on' => [self::SCENARIO_PROFILE_UPDATE]
                ],
                   [['managerFax'], 'default','value' => ''],
                   [['chiefPosition', 'chiefFio', 'chiefPhone', 'chiefEmail', 'managerPosition', 'managerFio', 'managerPhone', 'managerFax', 'managerEmail','proposalSignatureName','proposalSignaturePost'], 'string', 'max' => 255],
                   [['id'],'integer']            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chiefPosition' => 'Дожность руководителя',
            'chiefFio' => 'ФИО руководителя',
            'chiefPhone' => 'Телефон руководителя',
            'chiefEmail' => 'Email руководителя',
            'managerPosition' => 'Должность менеджера',
            'managerFio' => 'ФИО менеджера',
            'managerPhone' => 'Телефон менеджера',
            'managerFax' => 'Факс менеджера',
            'managerEmail' => 'Email менеджера',
            'proposalSignaturePost' => 'Должность подписанта',
            'proposalSignatureName' => 'ФИО подписанта',
        ];
    }    
}
