<?php

namespace app\models\ActiveRecord\Requests;

use Yii;
use yii\db\ActiveQuery;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "request_dynamic_forms".
 *
 * @property int $id
 * @property int $request_id Id заявки
 * @property int $amount Стоимость
 * @property string|null $fields Данные формы
 *
 * @property Request $request
 */
class RequestDynamicForm extends BaseRequest
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
        return 'request_dynamic_forms';
    }
    
    /**
     * 
     * @param int $requestId
     * @param string $fields
     * @param int $amount
     * @return \self
     */
    public static function create(
            int $requestId,
            string $fields,
            int $amount = 0
            ):self 
    {
        $request = new self();
        $request->request_id = $requestId;
        $request->fields = $fields;
        $request->amount = $amount;
        return $request;
        
    }
    
    /**
     * 
     * @param int $requestId
     * @param string $fields
     * @param int $amount
     */
    public function edit(
                int $requestId,
                string $fields,
                int $amount = 0
            )    
    {
        $this->request_id = $requestId;
        $this->fields = $fields;
        $this->amount = $amount;        
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id'], 'required'],
            [['request_id', 'amount'], 'integer'],
            [['fields'], 'string'],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::className(), 'targetAttribute' => ['request_id' => 'id']],
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
            'amount' => 'Amount',
            'fields' => 'Fields',
        ];
    }

    /**
     * Gets query for [[Request]].
     *
     * @return ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }  
}
