<?php

namespace app\models\ActiveRecord\Requests;

use app\models\ActiveRecord\Forms\Stand;
use Yii;
use yii\db\ActiveQuery;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "{{%request_stands}}".
 *

 * @property int $stand_id Тип стенда
 * @property int|null $width Ширина
 * @property int|null $length Длинна
 * @property int $square Площадь
 * @property int $stand_price Стоимость стенда
 * @property int $frize_price Стоимость фризовой надписи
 * @property string|null $frizeName Фризовая надпись
 * @property int $amount Стоимость
 * @property string|null $file Файл, приложенный к форме
 *
 * @property Stand $stand
 */
class RequestStand extends BaseRequest
{   
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->attachBehavior('fileUploadBehavior',
                [
                    'class' => FileUploadBehavior::class,
                    'attribute' => 'file',
                    'filePath' => Yii::getAlias('@standUploadPath') . DIRECTORY_SEPARATOR . '[[id]]_[[filename]].[[extension]]',
                    'fileUrl' => '@standUploadUrl/[[id]]_[[filename]].[[extension]]' 
                ] 
            );
    }

/**
 * 
 * @param int $requestId
 * @param int $standId
 * @param int $square
 * @param int $width
 * @param int $length
 * @param string $frizeName
 * @param int $standPrice
 * @param int $frizePrice
 * @param int $amount
 * @return \self
 */
    public static function create(
            int $requestId,
            int $standId,
            int $square,
            int $width,
            int $length,
            string $frizeName,
            int $standPrice,
            int $frizePrice,
            int $amount
            ):self 
    {
        $request = new self();
        $request->request_id = $requestId;
        $request->stand_id = $standId;
        $request->square =  $square;
        $request->width = $width;
        $request->length = $length;
        $request->frizeName = $frizeName;
        $request->stand_price = $standPrice;
        $request->frize_price = $frizePrice;
        $request->amount = $amount;
        return $request;
    }

/**
 * 
 * @param int $requestId
 * @param int $standId
 * @param int $square
 * @param int $width
 * @param int $length
 * @param string $frizeName
 * @param int $standPrice
 * @param int $frizePrice
 * @param int $amount
 */
    public function edit(           
            int $standId,
            int $square,
            int $width,
            int $length,
            string $frizeName,
            int $standPrice,
            int $frizePrice,
            int $amount            
            )
    {
        $this->stand_id = $standId;
        $this->square =  $square;
        $this->width = $width;
        $this->length = $length;
        $this->frizeName = $frizeName;
        $this->stand_price = $standPrice;
        $this->frize_price = $frizePrice;
        $this->amount = $amount;        
    }
    
     /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%request_stands}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Заказчик',
            'stand_id' => 'Тип стенда',
            'width' => 'Ширина',
            'length' => 'Длинна',
            'square' => 'Площадь',
            'frizeName' => 'Фризовая надпись',
            'amount' => 'Стоимость',
            'file' => 'Файл, приложенный к форме',
            'status' => 'Статус',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Stand]].
     *
     * @return ActiveQuery
     */
    public function getStand()
    {
        return $this->hasOne(Stand::className(), ['id' => 'stand_id']);
    }
    
    public function setFile(UploadedFile $file) 
    {
        $this->file = $file;
    }
}
