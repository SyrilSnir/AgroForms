<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\Forms\Manage\Forms;

use yii\base\Model;

/**
 * Description of CopyForm
 *
 * @author kotov
 */
class CopyForm extends Model
{
    public $exhibitionId;
    
    public $formId;
    
    public function rules()
    {
        return [
          [['exhibitionId', 'formId'],'integer' ]
        ];
    }
}
