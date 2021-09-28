<?php

namespace app\models\ActiveRecord\Requests;

use app\core\repositories\readModels\Requests\ApplicationReadRepository;
use app\core\repositories\readModels\Requests\RequestStandReadRepository;
use app\models\ActiveRecord\Exhibition\Exhibition;
use app\models\ActiveRecord\FormManipulation;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\FormType;
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
 * @property FormType $formType
 * @property User $user
 * @property Exhibition $exhibition
 * @property BaseRequest $requestForm
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

    public static function create(
            int $userId,
            int $exhibitionId,
            int $typeId,
            bool $draft = false
            ):self 
    {
        $request = new self();
        $request->user_id = $userId;
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
        /*
        return [
            [['user_id', 'form_type_id',  'status'], 'required'],
            [['user_id', 'form_type_id', 'amount', 'status'], 'integer'],
            [['data'], 'string'],
            [['form_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FormType::className(), 'targetAttribute' => ['form_type_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];*/
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [/*
            'id' => 'ID',
            'form_type_id' => 'Тип формы',
            'data' => 'Данные запроса',
            'amount' => 'К оплате',
            'status' => 'Status',*/
        ];
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
}
