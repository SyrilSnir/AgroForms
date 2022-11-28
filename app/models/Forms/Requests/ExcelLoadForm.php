<?php

namespace app\models\Forms\Requests;

use app\core\traits\Lists\GetExhibitionsTrait;
use app\core\traits\Lists\GetFormsListTrait;
use yii\base\Model;

/**
 * Description of ExcelLoadForm
 *
 * @author kotov
 */
class ExcelLoadForm extends Model
{
    use GetExhibitionsTrait, GetFormsListTrait;
    
    public $exhibitionId;
    
    public $formId;
    
    public function rules(): array
    {
        return [
            [['exhibitionId','formId'],'integer'],
        ];
    } 
 
    public function attributeLabels(): array 
    {
        return [
            'exhibitionId' => t('Exhibition'), 
            'formId' => t('Form name')
        ];
    }    
}
