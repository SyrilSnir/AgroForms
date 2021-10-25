<?php

namespace app\widgets\Forms;

use Yii;

/**
 * Description of StandWidget
 *
 * @author kotov
 */
class StandWidget extends FormWidget
{
    
    public function run(): string
    {
        Yii::$app->session->set('OPENED_FORM_ID', $this->formId);        
        return $this->render('stand',[
            'user' => $this->user,            
        ]);
    }    
}
