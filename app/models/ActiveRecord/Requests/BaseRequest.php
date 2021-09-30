<?php


namespace app\models\ActiveRecord\Requests;

use app\models\ActiveRecord\Users\User;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Description of BaseRequest
 * @property int $id
 * @property int $request_id Id заявки
 * @property string|null $file Файл, приложенный к форме
 * 
 * @property User $user
 * 
 * @author kotov
 */
abstract class BaseRequest extends ActiveRecord
{   
    const STATUS_NEW = 0; // Новая
    const STATUS_PAID = 1; // Оплачена
    const STATUS_PARTIAL_PAID = 6; // Частично оплачена 
    const STATUS_REJECTED = 2; // Отклонена
    
    /**
     * Изменена
     */
    const STATUS_CHANGED = 4; 
    
    /**
     * Удалена
     */
    const STATUS_DELETE = 5; 
    /**
     * Черновик
     */
    const STATUS_DRAFT = 3; 
    /**
     * Выставлен счет
     */
    const STATUS_INVOICED = 7; 
    const STATUS_ACCEPTED = 8; // Принята
    
    const TYPE_STAND = 1; // Заказ стенда
    const TYPE_APPLICATION = 2; // Заявки
    const TYPE_POLL = 3; // Опросы    
    
    const FORM_ID = '';
    
    public function setFile(UploadedFile $file) 
    {
        $this->file = $file;
    } 
    
    abstract public function getHeader():string;
}
