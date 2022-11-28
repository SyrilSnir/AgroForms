<?php

namespace app\models\ActiveRecord\Requests;

use app\models\ActiveRecord\Forms\Form;
use Yii;
use yii\db\ActiveQuery;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "application_forms".
 *
 * @property int $id
 * @property int $request_id Id заявки
 * @property int $form_id Id формы
 * @property int $amount Стоимость
 * @property string|null $fields Данные формы
 *
 * @property Request $request
 * @property Form $form 
 * 
 */
class Application extends BaseRequest
{
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->attachBehavior('fileUploadBehavior',
                [
                    'class' => FileUploadBehavior::class,
                    'attribute' => 'file',
                    'filePath' => Yii::getAlias('@formsUploadPath') . DIRECTORY_SEPARATOR . '[[id]]_[[filename]].[[extension]]',
                    'fileUrl' => '@formsUploadUrl/[[id]]_[[filename]].[[extension]]' 
                ] 
            );
    }    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%applications}}';
    }
    
    /**
     * 
     * @param int $requestId
     * @param int $formId
     * @param string $fields
     * @param int $amount
     * @return \self
     */
    public static function create(
            int $requestId,
            int $formId,
            string $fields,
            int $amount = 0
            ):self 
    {
        $request = new self();
        $request->request_id = $requestId;
        $request->form_id = $formId;
        $request->fields = $fields;
        $request->amount = $amount;
        return $request;   
    }
    
    /**
     * 
     * @param string $fields
     * @param int $amount
     */
    public function edit(
                string $fields,
                int $amount = 0
            )    
    {
        $this->fields = $fields;
        $this->amount = $amount;        
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id','form_id'], 'required'],
            [['request_id','form_id', 'amount'], 'integer'],
            [['fields'], 'string'],
            [['file'], 'file','skipOnEmpty' => true],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::className(), 'targetAttribute' => ['request_id' => 'id']],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => Form::className(), 'targetAttribute' => ['form_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'Request ID',
            'form_id' => 'Form ID',
            'amount' => 'Amount',
            'fields' => 'Fields',
        ];
    } 
}
