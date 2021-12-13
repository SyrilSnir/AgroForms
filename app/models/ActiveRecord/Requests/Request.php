<?php

namespace app\models\ActiveRecord\Requests;

use app\core\repositories\readModels\Requests\ApplicationReadRepository;
use app\core\repositories\readModels\Requests\RequestStandReadRepository;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\ActiveRecord\FormManipulation;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Logs\ApplicationRejectLog;
use app\models\ActiveRecord\Requests\Query\RequestQuery;
use app\models\ActiveRecord\Users\User;
use app\models\CreatedTimestampTrait;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%requests}}".
 *
 * @property int $id
 * @property int $user_id Заказчик
 * @property int $status
 * @property int $created_at
 * @property int $exhibition_id
 * @property int $type_id Тип заявки
 * @property int $form_id Тип заявки
 * @property bool $was_rejected Была отклонена
 * 
 * @property FormType $formType
 * @property Form $form
 * @property User $user
 * @property Exhibition $exhibition
 * @property BaseRequest $requestForm
 * @property ApplicationRejectLog|null $actualRejectLog
 * 
 */
class Request extends FormManipulation
{   
    use CreatedTimestampTrait;
    
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
     * @param int $typeId
     * @param bool $draft
     * @return self
     */
    public static function create(
            int $userId,
            int $formId,
            int $exhibitionId,
            int $typeId,
            bool $draft = false
            ):self 
    {
        $request = new self();
        $request->user_id = $userId;
        $request->form_id = $formId;
        $request->exhibition_id = $exhibitionId;
        $request->type_id = $typeId;
        if ($draft) {
            $request->setStatusDraft();
        } else {
            $request->setStatusNew();
        }
        return $request;
    }
    
    public function edit(
            int $userId       
            )
    {
        $this->user_id = $userId;
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
    
    
    /**
     * Заявку отклонена
     */
    public function reject()
    {
        $this->status = BaseRequest::STATUS_REJECTED;
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
}
