<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\ActiveRecord\Requests;

/**
 * Description of Polls
 *
 * @property int $id
 * @property int $request_id Id заявки
 * @property int $form_id Id формы
 * @property string|null $fields Данные формы
 *
 * @property Request $request
 * @property Form $form
 */
class Polls extends BaseRequest
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
        return '{{%polls}}';
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
            string $fields
            ):self 
    {
        $request = new self();
        $request->request_id = $requestId;
        $request->form_id = $formId;
        $request->fields = $fields;
        return $request;   
    }
    
    /**
     * 
     * @param string $fields
     * @param int $amount
     */
    public function edit(
                string $fields
            )    
    {
        $this->fields = $fields;       
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id','form_id'], 'required'],
            [['request_id','form_id'], 'integer'],
            [['fields'], 'string'],
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
    
    public function getForm()
    {
        return $this->hasOne(Form::class, ['id','form_id']);
    }
}
