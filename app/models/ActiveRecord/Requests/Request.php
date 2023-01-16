<?php

namespace app\models\ActiveRecord\Requests;

use app\core\repositories\readModels\Requests\ApplicationReadRepository;
use app\core\repositories\readModels\Requests\RequestStandReadRepository;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Contract\Contracts;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\ActiveRecord\FormManipulation;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Logs\ApplicationRejectLog;
use app\models\ActiveRecord\Requests\Query\RequestQuery;
use app\models\ActiveRecord\Users\User;
use app\models\Forms\Requests\EditRequestForm;
use app\models\TimestampTrait;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%requests}}".
 *
 * @property int $id
 * @property int $user_id Заказчик
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $activate_at
 * @property int $exhibition_id
 * @property int $type_id Тип заявки
 * @property int $form_id Id формы
 * @property int $contract_id Номер договора
 * @property int $company_id Id компании
 * 
 * @property bool $was_rejected Была отклонена
 * 
 * @property FormType $formType
 * @property Form $form
 * @property Contracts $contract
 * @property Company $company
 * @property User $user
 * @property Exhibition $exhibition
 * @property BaseRequest $requestForm
 * @property Attachment[] $attachments
 * @property ApplicationRejectLog|null $actualRejectLog
 * 
 */
class Request extends FormManipulation
{   
    use TimestampTrait;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%requests}}';
    }

    /**
     * 
     * @param int $userId
     * @param int $formId
     * @param int $exhibitionId
     * @param int $companyId
     * @param int $contractId
     * @param int $typeId
     * @param bool $draft
     * @return self
     */
    public static function create(
            int $userId,
            int $formId,            
            int $exhibitionId,
            int $companyId,
            int $contractId,            
            int $typeId,
            bool $draft = false
            ):self 
    {
        $request = new self();
        $request->user_id = $userId;
        $request->form_id = $formId;
        $request->exhibition_id = $exhibitionId;
        $request->company_id = $companyId;
        $request->contract_id = $contractId;
        $request->type_id = $typeId;
        if ($draft) {
            $request->setStatusDraft();
        } else {
            $request->setStatusNew();
        }
        return $request;
    }
    
    public function edit(
            EditRequestForm $form      
            )
    {
        $this->status = $form->status;
        $this->contract_id = $form->contractId;
    }
    
    public function setStatusNew()
    {
        $this->status = BaseRequest::STATUS_NEW;
    }
    
    public function setStatusDraft()
    {
        $this->status = BaseRequest::STATUS_DRAFT;
    }
    
    public function setStatusChanged()
    {
        $this->status = BaseRequest::STATUS_CHANGED;
    }    

    /**
     * Gets query for [[FormType]].
     *
     * @return ActiveQuery
     */
    public function getFormType()
    {
        return $this->hasOne(FormType::class, ['id' => 'type_id']);
    }
    
    /**
     * Gets query for [[Form]].
     *
     * @return ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form::class, ['id' => 'form_id']);
    }
    
    public function getStand()
    {
        return $this->hasOne(RequestStand::class, ['request_id' => 'id' ]);
    }
    
    public function getContract()
    {
        return $this->hasOne(Contracts::class, ['id' => 'contract_id' ]);
    }  
    
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }
    
    public function getApplication()
    {
        return $this->hasOne(Application::class, ['request_id' => 'id' ]);
    }    

    public function getRequestForm() : ?BaseRequest
    {
        switch ($this->type_id) {
            case FormType::SPECIAL_STAND_FORM:
                $request = RequestStandReadRepository::findByRequest($this->id);
                break;
            case FormType::DYNAMIC_INFORMATION_FORM:
            case FormType::DYNAMIC_ORDER_FORM:
                $request = ApplicationReadRepository::findByRequest($this->id);
                break;
                
        }
        
        return $request;
    }
    
    public function getHeader(): string
    {
        return $this->requestForm->header;
    }


    public function getExhibition()
    {
        return $this->hasOne(Exhibition::class, ['id' => 'exhibition_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * Возвращает должность подписанта экспонента
     * @return string
     */
    public function getExponentSignerPosition():string
    {
        return $this->user->company->contacts->proposal_signature_post ?? '';
    }
    
    /**
     * Возвращает ФИО подписанта экспонента
     * @return string
     */
    public function getExponentSignerFullName(): string
    {
        return $this->user->company->contacts->proposal_signature_name ?? '';
    }

    /**
     * Возвращает должность подписанта организатора
     * @return string
     */
    public function getOrganizerSignerPosition():string
    {
        return $this->form->exhibition->company->contacts->proposal_signature_post ?? '';
    }
    
    /**
     * Возвращает ФИО подписанта организатора
     * @return string
     */
    public function getOrganizerSignerFullName(): string
    {
        return $this->form->exhibition->company->contacts->proposal_signature_name ?? '';
    }    

    /**
     * 
     * @return RequestQuery
     */
    public static function find()
    {
        return new RequestQuery(static::class);
    }
    
    /**
     * Заявку принята
     */
    public function accept()
    {
        $this->status = BaseRequest::STATUS_ACCEPTED;
    }
    
    public function activate()
    {
        $this->activate_at = microtime(true);
    }
    
    public function deactivate()
    {
        $this->activate_at = null;
    }

    /**
     * Заявку отклонена
     */
    public function reject()
    {
        $this->status = BaseRequest::STATUS_REJECTED;
        $this->deactivate();
        $this->was_rejected = true;
    }  
    
    /**
     * Выставлен счет
     */
    public function invoice() 
    {
        $this->status = BaseRequest::STATUS_INVOICED;
    }
    
    /**
     * Оплата заявки
     */
    public function paid()
    {
        $this->status = BaseRequest::STATUS_PAID;
    }
    
    /**
     * Публикация на сайте
     */
    public function publish()
    {
        $this->status = BaseRequest::STATUS_PUBLICATED;
    }

    /**
     * Отмена публикации
     */
    public function withdraw()
    {
        $this->status = BaseRequest::STATUS_NOT_PUBLICATED;
    }

    /**
     * Частичная оплата
     */
    public function parialPaid()
    {
        $this->status = BaseRequest::STATUS_PARTIAL_PAID;
    }

    public function isNeedToChange(): bool
    {
        if ($this->isRejected()) {
            return true;
        }
        if ($this->isDraft()) {
            return (!empty($this->actualRejectLog));
        }
        return false;
    }
    
    public function isRejected(): bool
    {
        return $this->status === BaseRequest::STATUS_REJECTED;
    }
    
    public function isDraft(): bool 
    {
        return $this->status === BaseRequest::STATUS_DRAFT;
    }
    
    public function getActualRejectLog()
    {
        return $this->hasOne(ApplicationRejectLog::class, ['request_id' => 'id'])->andWhere(['actual' => true]);
    } 
    
    public function getAttachments() 
    {
        return $this->hasMany(AttachedFiles::class, ['request_id' => 'id']);
    }    
}
