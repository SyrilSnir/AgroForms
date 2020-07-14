<?php

namespace app\models\ActiveRecord;

use yii\db\ActiveRecord;

/**
 * Description of FormManipulation
 *
 * @author kotov
 */
class FormManipulation extends ActiveRecord
{
    const FORM_CREATE = 'create';
    const FORM_UPDATE = 'update';
}
