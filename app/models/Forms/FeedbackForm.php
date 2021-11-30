<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace app\models\Forms;

use app\models\ActiveRecord\FeedbackFormModel;
use app\models\ActiveRecord\Users\User;
use yii\base\Model;

/**
 * Description of FeedbackForm
 *
 * @author kotov
 */
class FeedbackForm extends Model
{
    public $message;
    public $userId;
    
    public function __construct(FeedbackFormModel $model = null, $config = [])
    {
        if ($model) {
            $this->message = $model->message;
            $this->userId = $model->user_id;
        }
        parent::__construct($config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'message'], 'required'],
            [['userId'], 'integer'],
            [['message'], 'string'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'message' => t('Message'),
            'created_at' => 'Created At',
        ];
    }    
}
