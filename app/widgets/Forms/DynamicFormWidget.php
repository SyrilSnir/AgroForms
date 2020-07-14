<?php

namespace app\widgets\Forms;

use Yii;

/**
 * Description of DynamicFormWidget
 *
 * @author kotov
 */
class DynamicFormWidget extends FormWidget
{
    public function run(): string
    {
        Yii::$app->session->set('OPENED_FORM_ID', $this->formId);
        return $this->render('dynamic-form',[
            'user' => $this->user,
        ]);
    }
}
