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
class BaseRequest extends ActiveRecord
{
    const FORM_ID = '';
    
    public function setFile(UploadedFile $file) 
    {
        $this->file = $file;
    }    
}
