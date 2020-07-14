<?php

namespace app\widgets\Forms;

use app\core\manage\Auth\UserIdentity;
use app\models\ActiveRecord\Forms\Form;
use app\models\ActiveRecord\Forms\Stand;
use yii\base\Widget;

/**
 * Description of StandWidget
 *
 * @author kotov
 */
class StandWidget extends FormWidget
{
    
    public function run(): string
    {
        return $this->render('stand',[
            'user' => $this->user,            
        ]);
    }    
}
