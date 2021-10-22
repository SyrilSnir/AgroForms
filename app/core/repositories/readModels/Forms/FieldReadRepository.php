<?php

namespace app\core\repositories\readModels\Forms;

use app\core\repositories\readModels\ReadRepositoryInterface;
use app\models\ActiveRecord\Forms\Field;

/**
 * Description of FieldReadRepository
 *
 * @author kotov
 */
class FieldReadRepository implements ReadRepositoryInterface
{
    public static function findById($id)
    {
        return Field::find($id)
            ->andWhere(['id' => $id])
            ->one();
    }
    
    public static function findForForm(int $formId = null):array
    {
        return Field::find()
                ->andFilterWhere(['form_id' => $formId])
                ->andFilterWhere(['deleted' => false])
                ->orderBy(['order' => SORT_ASC])
                ->asArray()
                ->all();        
    }    
}
