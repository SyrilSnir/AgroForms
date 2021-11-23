<?php
namespace app\core\repositories\manage\Forms;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\models\ActiveRecord\Forms\FieldEnum;
use yii\db\ActiveRecord;

/**
 * Description of FieldEnumRepository
 *
 * @author kotov
 */
class FieldEnumRepository
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = FieldEnum::findOne($id)) {
            throw new NotFoundException('Не найдено выбранное поле');
        }
        return $model;
    }
}