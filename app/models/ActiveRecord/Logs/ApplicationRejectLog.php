<?php

namespace app\models\ActiveRecord\Logs;

use Yii;

/**
 * This is the model class for table "{{%application_reject_log}}".
 *
 * @property int $id
 * @property int $request_id Id заявки
 * @property string|null $comment Комментарий
 * @property int $actual Актуальность
 * @property string $date Дата
 *
 * @property Requests $request
 */
class ApplicationRejectLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%application_reject_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'date'], 'required'],
            [['request_id', 'actual'], 'integer'],
            [['comment'], 'string'],
            [['date'], 'safe'],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Requests::className(), 'targetAttribute' => ['request_id' => 'id']],
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
            'comment' => 'Comment',
            'actual' => 'Actual',
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[Request]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Requests::className(), ['id' => 'request_id']);
    }
}
