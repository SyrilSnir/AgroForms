<?php

namespace app\models\ActiveRecord\Requests;

use app\core\repositories\readModels\Requests\RequestDynamicFormReadRepository;
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
 * @property int $form_id Id формы
 * @property int $status
 * @property int $created_at
 * @property int $exhibition_id
 * 
 * @property FormType $formType
 * @property Form $form
 * @property User $user
 * @property Exhibition $exhibition
 * @property BaseRequest $requestForm
 * 
 */
class Request extends FormManipulation
{
    const STATUS_NEW = 0; // Новая
    const STATUS_PAID = 1; // Оплачена
    const STATUS_PARTIAL_PAID = 6; // Частично оплачена 
    const STATUS_REJECTED = 2; // Отклонена
    const STATUS_CHANGED = 4; // Изменена
    const STATUS_DELETE = 5; // Удалена
    const STATUS_DRAFT = 3; // Черновик
    const STATUS_INVOICED = 7; // Выставлен счет
    const STATUS_ACCEPTED = 8; // Принята
    
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
            int $formId,
            int $exhibitionId,
            bool $draft = false
            ):self 
    {
        $request = new self();
        $request->user_id = $userId;
        $request->form_id = $formId;
        $request->exhibition_id = $exhibitionId;
        if ($draft) {
            $request->setStatusDraft();
        } else {
            $request->setStatusNew();
        }
        return $request;
    }
    
    public function edit(
            int $userId,
            int $formId         
            )
    {
        $this->user_id = $userId;
        $this->form_id = $formId;
    }
    
    public function setStatusNew()
    {
        $this->status = self::STATUS_NEW;
    }
    
    public function setStatusDraft()
    {
        $this->status = self::STATUS_DRAFT;
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
        return $this->form->hasOne(FormType::class, ['id' => 'form_type_id']);
    }
    
    public function getForm()
    {
        return $this->hasOne(Form::class, ['id' => 'form_id']);
    }
  
    public function getStands()
    {
        return $this->hasMany(RequestStand::class, ['request_id' => 'id' ]);
    }
      
    public function getApplications()
    {
        
    }


    public function getRequestForm() : ?BaseRequest
    {
        switch ($this->form->form_type_id) {
            case FormType::SPECIAL_STAND_FORM:
                $request = RequestStandReadRepository::findByRequest($this->id);
                break;
            case FormType::DYNAMIC_INFORMATION_FORM:
            case FormType::DYNAMIC_ORDER_FORM:
                $request = RequestDynamicFormReadRepository::findByRequest($this->id);
                break;
                
        }
        
        return $request;
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
