<?php

namespace app\models\ActiveRecord\Requests;

use app\models\ActiveRecord\Users\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Description of BaseRequest
 * @property int $id
 * @property int $request_id Id заявки
 * 
 * @property User $user
 * 
 * @author kotov
 */
class BaseRequest extends ActiveRecord
{
    const FORM_ID = '';
}
