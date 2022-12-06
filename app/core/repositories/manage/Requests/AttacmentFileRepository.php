<?php

namespace app\core\repositories\manage\Requests;

use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Requests\AttachedFiles;
use Mpdf\Container\NotFoundException;
use yii\db\ActiveRecord;

/**
 * Description of AttacmentFileRepository
 *
 * @author kotov
 */
class AttacmentFileRepository implements RepositoryInterface
{
    use DataManipulationTrait;
    
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = AttachedFiles::findOne($id)) {
            throw new NotFoundException('Выставка не найдена');
        }
        return $model;
    }
}
