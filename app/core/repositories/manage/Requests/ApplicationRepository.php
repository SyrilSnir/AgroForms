<?php

namespace app\core\repositories\manage\Requests;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\models\ActiveRecord\Requests\Application;
use yii\db\ActiveRecord;

/**
 * Description of RequestDynamicFormRepository
 *
 * @author kotov
 */
class ApplicationRepository
{
    use DataManipulationTrait;
    
    public function get(int $id): ActiveRecord
    {
        if (!$model = Application::findOne($id)) {
            throw new NotFoundException('Заявка не найдена');
        }
        return $model;
    }
    
    public function findByRequest(int $requestId): ActiveRecord
    {
        if (!$model = Application::findOne(['request_id' => $requestId])) {
            throw new NotFoundException('Заявка не найдена');
        }
        return $model;        
    }
}
