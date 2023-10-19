<?php

namespace app\models\Forms;

use Yii;
use yii\base\Model;

/**
 * Description of CatalogLoadFrom
 *
 * @author kotov
 */
class CatalogLoadForm extends Model
{
    public $exhibitionId;    
    
    public function rules(): array
    {
        return [
            [['exhibitionId'], 'integer']
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'exhibitionId' => Yii::t('app','Exhibition') .':',
        ];
    }
    
}
