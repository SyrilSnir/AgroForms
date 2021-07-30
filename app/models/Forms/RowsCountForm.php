<?php

namespace app\models\Forms;

use yii\base\Model;

/**
 * Description of RowsCountForm
 *
 * @author kotov
 */
class RowsCountForm extends Model
{
    const DEFAULT_ROWS_COUNT = 20;
    
    public $rowsCount;
    
    public function rules(): array
    {
        return [
            [['rowsCount'], 'safe']
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'rowsCount' => \Yii::t('app','Rows count') .':'
        ];
    }
}
