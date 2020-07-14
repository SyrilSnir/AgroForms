<?php

namespace app\core\repositories\manage\Companies;

use app\core\repositories\exceptions\NotFoundException;
use app\core\repositories\manage\DataManipulationTrait;
use app\core\repositories\manage\RepositoryInterface;
use app\models\ActiveRecord\Companies\Contact;
use yii\db\ActiveRecord;

/**
 * Description of ContactRepository
 *
 * @author kotov
 */
class ContactRepository implements RepositoryInterface
{
    use DataManipulationTrait;
        
    public function get(int $id): ActiveRecord
    {
        if (!$model = Contact::findOne($id)) {
            throw new NotFoundException('Услуга не найдена');
        }
        return $model;
    }
}
