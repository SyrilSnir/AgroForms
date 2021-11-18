<?php

namespace app\models\ActiveRecord\Logs;

use app\core\traits\ActiveRecord\MultilangTrait;
use DateTime;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%application_reject_log}}".
 *
 * @property int $id
 * @property int $request_id Id заявки
 * @property string|null $comment Комментарий
 * @property string|null $comment_eng Комментарий (ENG)
 * @property int $actual Актуальность
 * @property string $date Дата
 * @property string $formatDate Отформатированная дата
 * @property string $formatDateEng Отформатированная дата
 *
 * @property Requests $request
 */
class ApplicationRejectLog extends ActiveRecord
{
    use MultilangTrait;
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
                ],
                 'value' => new Expression('NOW()'),
            ],
        ];
    } 
    
    public function extraMultilangFields()
    {
        return [
            'formatDate',
            'formatDateEng'
        ];
    }
    /**
     * 
     * @param int $requestId
     * @param string $comment
     * @return self
     */
    public static function create(
            int $requestId, 
            string $comment = '', 
            string $commentEng = '') : self
    {
        $model = new self();
        $model->request_id = $requestId;
        $model->comment = $comment;
        $model->comment_eng = $commentEng;
        $model->actual = true;
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%application_reject_log}}';
    }

    /**
     * Gets query for [[Request]].
     *
     * @return ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Requests::className(), ['id' => 'request_id']);
    }
    
    public function getFormatDate()
    {
        return DateTime::createFromFormat('Y-m-d H:i:s',$this->date)->format('d.m.Y H:i');;
    }
    
    public function getFormatDateEng()
    {
        return DateTime::createFromFormat('Y-m-d H:i:s',$this->date)->format('Y-m-d H:i');;
    } 
    
    
    
    
}
